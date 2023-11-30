<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\User;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        $user['meta'] = UserMeta::where('id', $user->user_meta_id)->first();
        $user['installation'] = Installation::where('user_id', $user->id)->first();
        if ($user) {
            return ResponseFormatter::success(['user' => $user]);
        } else {
            return ResponseFormatter::error();
        }
    }

    function getUser()
    {
        $data = User::where('role', 'user')->get();
        return ResponseFormatter::success($data);
    }

    function createUser(Request $request)
    {
        $meta = UserMeta::create([
            'phone' => $request->phone,
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
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
            'xmedia_id' => $request->xmedia_id,
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'user_meta_id' => $meta->id,
        ]);
        $tanggalSekarang = Carbon::now();
        $tanggalPertamaBulanDepan = $tanggalSekarang->addMonthsNoOverflow()->startOfMonth();
        $tanggal20BulanDepan = $tanggalPertamaBulanDepan->addDays(19);
        Installation::create([
            'status' => 'Aktif',
            'date_install' => now()->format('Y-m-d H:i:s'),
            'first_payment' => $request->first_payment,
            'end_date' => $tanggal20BulanDepan->format('Y-m-d H:i:s'),
            'user_id' => $user->id,
        ]);
        return ResponseFormatter::success();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return ResponseFormatter::error(null, 'Password lama salah', 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return ResponseFormatter::success();
    }
}
