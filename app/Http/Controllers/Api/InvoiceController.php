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
            $data = Invoice::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->with('user.userMeta.package', 'user.installations')->get();
        } else {
            $data = Invoice::orderBy('created_at', 'DESC')->with('user.userMeta.package', 'user.installations')->get();
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

    function bulkCreateInvoice()
    {
        $data = Installation::where('status', 'Aktif')->with('user')->get();
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
                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price - $potonganHarga,
                    'status' => "PENDING",
                    'invoice_url' =>  "-",
                    'user_id' => $item['user']['id'],
                ]);
            } else {
                $datePart = date("Ymd");
                $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $external_id = "INV-$datePart-$randomPart";
                $userMeta = UserMeta::where('id', $item['user']['user_meta_id'])->first();
                $package = Package::where('id', $userMeta['package_id'])->first();

                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price,
                    'status' => "PENDING",
                    'invoice_url' =>  "-",
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

                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price - $potonganHarga,
                    'status' => "PENDING",
                    'invoice_url' =>  "-",
                    'user_id' => $item['user']['id'],
                ]);
            } else {
                $datePart = date("Ymd");
                $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $external_id = "INV-$datePart-$randomPart";
                $userMeta = UserMeta::where('id', $item['user']['user_meta_id'])->first();
                $package = Package::where('id', $userMeta['package_id'])->first();

                Invoice::create([
                    'external_id' => $external_id,
                    'price' => (int)$package->price,
                    'status' => "PENDING",
                    'invoice_url' =>  "-",
                    'user_id' => $item['user']['id'],
                ]);
            }
        }

        return ResponseFormatter::success();
    }
}
