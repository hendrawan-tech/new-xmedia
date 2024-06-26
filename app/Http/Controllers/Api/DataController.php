<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    function district()
    {
        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kecamatan/3511.json');
        $response = $data_request->object();
        return ResponseFormatter::success($response);
    }

    function ward(Request $request)
    {
        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kelurahan/' . $request->district_id . '.json');
        $response = $data_request->object();
        return ResponseFormatter::success($response);
    }

    function package()
    {
        $response = Package::all();
        return ResponseFormatter::success($response);
    }

    function getPerWard(Request $request)
    {
        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kelurahan/' . $request->district_id . '.json');
        if ($data_request->successful()) {
            $wards = $data_request->json();

            $clientWard = [];

            foreach ($wards as $ward) {
                $meta = UserMeta::where('ward_id', $ward['id'])->count();

                $clientWard[] = [
                    'name' => $ward['nama'],
                    'total' => $meta,
                ];
            }
        }
        return ResponseFormatter::success($clientWard);
    }
}
