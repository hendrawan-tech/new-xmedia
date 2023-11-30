<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\User;
use App\Models\UserMeta;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstallationController extends Controller
{
    function listInstallation(Request $request)
    {
        $data = Installation::where(['status' => 'Antrian'])->with('user.userMeta.package')->get();
        return ResponseFormatter::success($data);
    }

    function installation(Request $request)
    {
        $userMeta = UserMeta::create([
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'phone' => $request->phone,
            'longlat' => $request->longlat,
            'province_id' => "35",
            'province_name' => "JAWA TIMUR",
            'regencies_id' => "3511",
            'regencies_name' => "KAB. BONDOWOSO",
            'district_id' => $request->district_id,
            'district_name' => $request->district_name,
            'ward_id' => $request->ward_id,
            'ward_name' => $request->ward_name,
            'package_id' => $request->package_id,
        ]);

        $user = User::where('id', $request->user()->id)->first();

        $user->update([
            'user_meta_id' => $userMeta->id,
        ]);

        $dateTime = new DateTime(now()->format('Y-m-d H:i:s'));
        $dateTime->modify('+1 month');
        $newDate = $dateTime->format('Y-m-d');

        Installation::create([
            'status' => "Antrian",
            'date_install' => now()->format('Y-m-d H:i:s'),
            'end_date' => $newDate,
            'user_id' => $request->user()->id,
        ]);

        return ResponseFormatter::success();
    }

    function updateInstallation(Request $request)
    {
        $dateTime = new DateTime(now()->format('Y-m-d H:i:s'));
        $dateTime->modify('+1 month');
        $newDate = $dateTime->format('Y-m-d');
        Installation::where('id', $request->id)->first()->update([
            'status' => 'Aktif',
            'date_install' => now()->format('Y-m-d H:i:s'),
            'end_date' => $newDate,
            'price' => $request->price,
        ]);

        return ResponseFormatter::success();
    }
}
