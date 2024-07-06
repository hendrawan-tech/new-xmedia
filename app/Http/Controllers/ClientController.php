<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Package;
use App\Models\User;
use App\Models\UserMeta;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->with('installations')->where('role', 'user')->get();
        return view('client.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kecamatan/3511.json');
        $district = $data_request->object();
        $packages = Package::all();
        return view('client.create', compact('district', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->status == 'Aktif') {
            $data = $request->validate([
                'xmedia_id' => 'required',
                'nik' => 'required|max:16',
                'name' => 'required|min:3',
                'phone' => 'required|regex:/(0)[0-9]{9}/|max:16',
                'address' => 'required|min:3',
                'email' => 'required|min:3|unique:users,email',
                'district_id' => 'required',
                'ward_id' => 'required',
                'rt' => 'required|numeric',
                'rw' => 'required|numeric',
                'package_id' => 'required',
                'date_install' => 'required',
                'end_date' => 'required',
                'status' => 'required',
            ]);
        } else {
            $data = $request->validate([
                'xmedia_id' => 'required',
                'nik' => 'required|max:16',
                'name' => 'required|min:3',
                'phone' => 'required|regex:/(0)[0-9]{9}/|max:16',
                'address' => 'required|min:3',
                'email' => 'required|min:3|unique:users,email',
                'district_id' => 'required',
                'ward_id' => 'required',
                'rt' => 'required|numeric',
                'rw' => 'required|numeric',
                'package_id' => 'required',
                'status' => 'required',
            ]);
        }

        $userMeta = UserMeta::create([
            'address' => $data['address'],
            'nik' => $data['nik'],
            'xmedia_id' => $data['xmedia_id'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'phone' => $data['phone'],
            'longlat' => "default",
            'province_id' => "35",
            'province_name' => "JAWA TIMUR",
            'regencies_id' => "3511",
            'regencies_name' => "KAB. BONDOWOSO",
            'district_id' => $data['district_id'],
            'district_name' => $request->district_name,
            'ward_id' => $data['ward_id'],
            'ward_name' => $request->ward_name,
            'package_id' => $data['package_id'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'user',
            'user_meta_id' => $userMeta->id,
            'password' => Hash::make('password'),
        ]);

        Installation::create([
            'status' => $request->status == 'Aktif' ? "Aktif" : 'Antrian',
            'date_install' => $request->status == 'Aktif' ? $data['date_install'] : now()->format('Y-m-d H:i:s'),
            'end_date' => $request->status == 'Aktif' ? $data['end_date'] : Carbon::now()->addMonth()->startOfMonth(),
            'user_id' => $user->id,
            'first_payment' => $request->status == 'Aktif' ? '2' : '1',
        ]);

        return redirect('/user/clients')->with('success', 'Pelanggan Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $client)
    {
        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kecamatan/3511.json');
        $district = $data_request->object();
        $packages = Package::all();
        return view('client.edit', compact('district', 'packages', 'client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $client)
    {
        if ($request->status == 'Aktif') {
            $data = $request->validate([
                'xmedia_id' => 'required',
                'nik' => 'required|max:16',
                'name' => 'required|min:3',
                'phone' => 'required|regex:/(0)[0-9]{9}/|max:16',
                'address' => 'required|min:3',
                'email' => 'required|min:3',
                'district_id' => 'required',
                'ward_id' => 'required',
                'rt' => 'required|numeric',
                'rw' => 'required|numeric',
                'package_id' => 'required',
                'date_install' => 'required',
                'end_date' => 'required',
                'status' => 'required',
            ]);
        } else {
            $data = $request->validate([
                'xmedia_id' => 'required',
                'nik' => 'required|max:16',
                'name' => 'required|min:3',
                'phone' => 'required|regex:/(0)[0-9]{9}/|max:16',
                'address' => 'required|min:3',
                'email' => 'required|min:3',
                'district_id' => 'required',
                'ward_id' => 'required',
                'rt' => 'required|numeric',
                'rw' => 'required|numeric',
                'package_id' => 'required',
                'status' => 'required',
            ]);
        }

        $userMeta = UserMeta::create([
            'address' => $data['address'],
            'nik' => $data['nik'],
            'xmedia_id' => $data['xmedia_id'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'phone' => $data['phone'],
            'longlat' => "default",
            'province_id' => "35",
            'province_name' => "JAWA TIMUR",
            'regencies_id' => "3511",
            'regencies_name' => "KAB. BONDOWOSO",
            'district_id' => $data['district_id'],
            'district_name' => $request->district_name,
            'ward_id' => $data['ward_id'],
            'ward_name' => $request->ward_name,
            'package_id' => $data['package_id'],
        ]);

        $client->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'user',
            'user_meta_id' => $userMeta->id,
            'password' => Hash::make('password'),
        ]);

        $client->installations->update([
            'status' => $request->status == 'Aktif' ? "Aktif" : 'Antrian',
            'date_install' => $request->status == 'Aktif' ? $data['date_install'] : now()->format('Y-m-d H:i:s'),
            'end_date' => $request->status == 'Aktif' ? $data['end_date'] : Carbon::now()->addMonth()->startOfMonth(),
            'user_id' => $client->id,
            'first_payment' => $request->status == 'Aktif' ? '2' : '1',
        ]);

        return redirect('/user/clients')->with('success', 'Pelanggan Ditambah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $client)
    {
        $client->delete();
        return redirect('/user/clients')->with('success', 'Pelanggan Dihapus');
    }
}
