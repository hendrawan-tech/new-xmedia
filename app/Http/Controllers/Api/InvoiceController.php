<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    function listInvoice(Request $request)
    {
        $user = $request->user();
        if ($user->role == 'user') {
            $data = Invoice::where(['user_id' => $user->id, 'status' => 'Pending'])->with('user.userMeta.package', 'user.installations')->get();
        } else {
            $data = Invoice::where(['status' => 'Pending'])->with('user.userMeta.package', 'user.installations')->get();
        }
        return ResponseFormatter::success($data);
    }

    function paymentOffline(Request $request)
    {
        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $invoice->update([
            'invoice_url' => "Cash",
            'status' => "SUCCESS",
        ]);
        $installation = Installation::where('user_id', $invoice->user_id)->first();
        $tanggalSekarang = Carbon::now();
        $tanggalPertamaBulanDepan = $tanggalSekarang->addMonthsNoOverflow()->startOfMonth();
        $tanggal20BulanDepan = $tanggalPertamaBulanDepan->addDays(19);

        $installation->update([
            'end_date' => $tanggal20BulanDepan,
        ]);
        return ResponseFormatter::success();
    }

    // function paymentXendit(Request $request)
    // {
    //     $user = $request->user();
    //     $secret_key = 'Basic ' . config('xendit.key_auth');
    //     $invoice = Invoice::where('id', $request->id)->first();

    //     $data_request = Http::withHeaders([
    //         'Authorization' => $secret_key
    //     ])->post('https://api.xendit.co/v2/invoices', [
    //         'external_id' => (string)$invoice->external_id,
    //         'amount' => (int)$user->userMeta->package->price,
    //         "payer_email" => $user->email,
    //         "description" => "Pembayaran Tagihan Wifi " . $user->name,
    //     ]);
    //     $response = $data_request->object();
    //     $invoice->update([
    //         'invoice_url' => $response->invoice_url,
    //     ]);
    //     return ResponseFormatter::success($invoice);
    // }

    // function createInvoice(Request $request)
    // {
    //     $user = $request->user();
    //     $secret_key = 'Basic ' . config('xendit.key_auth');

    //     $datePart = date("Ymd");
    //     $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    //     $external_id = "INV-$datePart-$randomPart";

    //     $data_request = Http::withHeaders([
    //         'Authorization' => $secret_key
    //     ])->post('https://api.xendit.co/v2/invoices', [
    //         'external_id' => (string)$external_id,
    //         'amount' => (int)$user->userMeta->package->price,
    //         'invoice_duration' => 1728000,
    //         "description" => "Pembayaran Tagihan Wifi " . $user->name,
    //         'customer' => [
    //             'given_names' => $user->name,
    //             'surname' => '-',
    //             'email' => $user->email,
    //             'mobile_number' => !Str::startsWith($user->userMeta->phone, '+62') ? '+62' . ltrim($user->userMeta->phone, '0') : $user->userMeta->phone,
    //             'addresses' => [
    //                 [
    //                     'city' => $user->userMeta->regencies_name,
    //                     'country' => 'Indonesia',
    //                     'postal_code' => '-',
    //                     'state' => $user->userMeta->district_name,
    //                     'street_line1' => $user->userMeta->address,
    //                     'street_line2' => $user->userMeta->ward_name,
    //                 ]
    //             ]
    //         ],
    //         'customer_notification_preference' => [
    //             'invoice_created' => [
    //                 'whatsapp',
    //                 'sms',
    //                 'email'
    //             ],
    //             'invoice_reminder' => [
    //                 'whatsapp',
    //                 'sms',
    //                 'email'
    //             ],
    //             'invoice_paid' => [
    //                 'whatsapp',
    //                 'sms',
    //                 'email'
    //             ],
    //             'invoice_expired' => [
    //                 'whatsapp',
    //                 'sms',
    //                 'email'
    //             ]
    //         ],
    //     ]);
    //     $response = $data_request->object();
    //     Invoice::create([
    //         'external_id' => $external_id,
    //         'price' => (int)$user->userMeta->package->price,
    //         'status' => $response->status,
    //         'invoice_url' => $response->invoice_url,
    //         'user_id' => $user->id,
    //     ]);
    //     return ResponseFormatter::success();
    // }

    function bulkCreateInvoice()
    {
        $secret_key = 'Basic ' . config('xendit.key_auth');
        $data = Installation::with('user')->get();

        $tanggalSekarang = Carbon::now();
        $tanggal20BulanIni = $tanggalSekarang->copy()->addDays(19);
        $tanggalPertamaBulanDepan = $tanggalSekarang->addMonthsNoOverflow()->startOfMonth();
        $tanggal20BulanDepan = $tanggalPertamaBulanDepan->addDays(19);

        foreach ($data as $item) {
            if ($item['first_payment'] == '1') {
                $datePart = date("Ymd");
                $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $external_id = "INV-$datePart-$randomPart";
                $userMeta = UserMeta::where('id', $item['user']['user_meta_id'])->first();
                $package = Package::where('id', $userMeta['package_id'])->first();

                $tanggalAwal = Carbon::parse($item['date_install']);
                $jarakHari = 0;
                if ($tanggalAwal->greaterThanOrEqualTo(Carbon::now()->startOfMonth()->addDays(19))) {
                    $jarakHari = $tanggalAwal->diffInDays($tanggal20BulanDepan);
                } else {
                    $jarakHari = $tanggalAwal->diffInDays($tanggal20BulanIni);
                }
                $potonganHarga = 3000 * $jarakHari;
                $data_request = Http::withHeaders([
                    'Authorization' => $secret_key
                ])->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => (string)$external_id,
                    'amount' => (int)$package->price - $potonganHarga,
                    'invoice_duration' => 1728000,
                    "description" => "Tagihan Wifi",
                    'customer' => [
                        'given_names' => $item['user']['name'],
                        'surname' => '-',
                        'email' => $item['user']['email'],
                        'mobile_number' => !Str::startsWith($userMeta->phone, '+62') ? '+62' . ltrim($userMeta->phone, '0') : $userMeta->phone,
                        'addresses' => [
                            [
                                'city' => $userMeta->regencies_name,
                                'country' => 'Indonesia',
                                'postal_code' => '-',
                                'state' => $userMeta->district_name,
                                'street_line1' => $userMeta->address,
                                'street_line2' => $userMeta->ward_name,
                            ]
                        ]
                    ],
                    'customer_notification_preference' => [
                        'invoice_created' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_reminder' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_paid' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_expired' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ]
                    ],
                ]);

                $response = $data_request->object();

                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price - $potonganHarga,
                    'status' => $response->status,
                    'invoice_url' =>  $response->invoice_url,
                    'user_id' => $item['user']['id'],
                ]);
            } else {
                $datePart = date("Ymd");
                $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $external_id = "INV-$datePart-$randomPart";
                $userMeta = UserMeta::where('id', $item['user']['user_meta_id'])->first();
                $package = Package::where('id', $userMeta['package_id'])->first();

                $data_request = Http::withHeaders([
                    'Authorization' => $secret_key
                ])->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => (string)$external_id,
                    'amount' => (int)$package->price,
                    'invoice_duration' => 1728000,
                    "description" => "Tagihan Wifi",
                    'customer' => [
                        'given_names' => $item['user']['name'],
                        'surname' => '-',
                        'email' => $item['user']['email'],
                        'mobile_number' => !Str::startsWith($userMeta->phone, '+62') ? '+62' . ltrim($userMeta->phone, '0') : $userMeta->phone,
                        'addresses' => [
                            [
                                'city' => $userMeta->regencies_name,
                                'country' => 'Indonesia',
                                'postal_code' => '-',
                                'state' => $userMeta->district_name,
                                'street_line1' => $userMeta->address,
                                'street_line2' => $userMeta->ward_name,
                            ]
                        ]
                    ],
                    'customer_notification_preference' => [
                        'invoice_created' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_reminder' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_paid' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_expired' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ]
                    ],
                ]);

                $response = $data_request->object();

                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price,
                    'status' => $response->status,
                    'invoice_url' =>  $response->invoice_url,
                    'user_id' => $item['user']['id'],
                ]);
            }
        }

        return ResponseFormatter::success();
    }

    function myInvoice(Request $request)
    {
        $user = $request->user();
        $data = Invoice::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->first();
        return ResponseFormatter::success($data);
    }

    function checkStatus(Request $request)
    {
        $data = Invoice::where('id', $request->id)->with('user.userMeta.package', 'user.installations')->first();
        return ResponseFormatter::success($data);
    }

    public function handleCallback(Request $request)
    {
        $payload = $request->all();
        if ($payload['status'] === 'PAID') {
            $invoice = Invoice::where('external_id', $payload['external_id'])->first();
            if ($invoice) {
                $invoice->update([
                    'status' => "SUCCESS",
                ]);

                $installation = Installation::where('user_id', $invoice->user_id)->first();
                if ($installation) {
                    $tanggalSekarang = Carbon::now();
                    $tanggalPertamaBulanDepan = $tanggalSekarang->addMonthsNoOverflow()->startOfMonth();
                    $tanggal20BulanDepan = $tanggalPertamaBulanDepan->addDays(19);

                    $installation->update([
                        'end_date' => $tanggal20BulanDepan,
                    ]);
                } else {
                    return ResponseFormatter::error();
                }
            } else {
                return ResponseFormatter::error();
            }
        }
        return ResponseFormatter::success();
    }


    public function resetData(Request $request)
    {
        Artisan::call('migrate:fresh', [
            '--seed' => true,
        ]);

        $secret_key = 'Basic ' . config('xendit.key_auth');
        $data = Installation::with('user')->get();

        $tanggalSekarang = Carbon::now();
        $tanggal20BulanIni = $tanggalSekarang->copy()->addDays(19);
        $tanggalPertamaBulanDepan = $tanggalSekarang->addMonthsNoOverflow()->startOfMonth();
        $tanggal20BulanDepan = $tanggalPertamaBulanDepan->addDays(19);

        foreach ($data as $item) {
            if ($item['first_payment'] == '1') {
                $datePart = date("Ymd");
                $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $external_id = "INV-$datePart-$randomPart";
                $userMeta = UserMeta::where('id', $item['user']['user_meta_id'])->first();
                $package = Package::where('id', $userMeta['package_id'])->first();

                $tanggalAwal = Carbon::parse($item['date_install']);
                $jarakHari = 0;
                if ($tanggalAwal->greaterThanOrEqualTo(Carbon::now()->startOfMonth()->addDays(19))) {
                    $jarakHari = $tanggalAwal->diffInDays($tanggal20BulanDepan);
                } else {
                    $jarakHari = $tanggalAwal->diffInDays($tanggal20BulanIni);
                }
                $potonganHarga = 3000 * $jarakHari;
                $data_request = Http::withHeaders([
                    'Authorization' => $secret_key
                ])->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => (string)$external_id,
                    'amount' => (int)$package->price - $potonganHarga,
                    'invoice_duration' => 1728000,
                    "description" => "Tagihan Wifi",
                    'customer' => [
                        'given_names' => $item['user']['name'],
                        'surname' => '-',
                        'email' => $item['user']['email'],
                        'mobile_number' => !Str::startsWith($userMeta->phone, '+62') ? '+62' . ltrim($userMeta->phone, '0') : $userMeta->phone,
                        'addresses' => [
                            [
                                'city' => $userMeta->regencies_name,
                                'country' => 'Indonesia',
                                'postal_code' => '-',
                                'state' => $userMeta->district_name,
                                'street_line1' => $userMeta->address,
                                'street_line2' => $userMeta->ward_name,
                            ]
                        ]
                    ],
                    'customer_notification_preference' => [
                        'invoice_created' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_reminder' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_paid' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_expired' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ]
                    ],
                ]);

                $response = $data_request->object();

                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price - $potonganHarga,
                    'status' => $response->status,
                    'invoice_url' =>  $response->invoice_url,
                    'user_id' => $item['user']['id'],
                ]);
            } else {
                $datePart = date("Ymd");
                $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $external_id = "INV-$datePart-$randomPart";
                $userMeta = UserMeta::where('id', $item['user']['user_meta_id'])->first();
                $package = Package::where('id', $userMeta['package_id'])->first();

                $data_request = Http::withHeaders([
                    'Authorization' => $secret_key
                ])->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => (string)$external_id,
                    'amount' => (int)$package->price,
                    'invoice_duration' => 1728000,
                    "description" => "Tagihan Wifi",
                    'customer' => [
                        'given_names' => $item['user']['name'],
                        'surname' => '-',
                        'email' => $item['user']['email'],
                        'mobile_number' => !Str::startsWith($userMeta->phone, '+62') ? '+62' . ltrim($userMeta->phone, '0') : $userMeta->phone,
                        'addresses' => [
                            [
                                'city' => $userMeta->regencies_name,
                                'country' => 'Indonesia',
                                'postal_code' => '-',
                                'state' => $userMeta->district_name,
                                'street_line1' => $userMeta->address,
                                'street_line2' => $userMeta->ward_name,
                            ]
                        ]
                    ],
                    'customer_notification_preference' => [
                        'invoice_created' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_reminder' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_paid' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ],
                        'invoice_expired' => [
                            'whatsapp',
                            'sms',
                            'email'
                        ]
                    ],
                ]);

                $response = $data_request->object();

                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price,
                    'status' => $response->status,
                    'invoice_url' =>  $response->invoice_url,
                    'user_id' => $item['user']['id'],
                ]);
            }
        }

        return ResponseFormatter::success();
    }
}
