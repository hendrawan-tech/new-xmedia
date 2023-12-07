<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Package;
use App\Models\User;
use App\Models\UserMeta;
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
        $data = $request->validate([
            'xmedia_id' => 'required',
            'name' => 'required|min:3',
            'phone' => 'required|regex:/(0)[0-9]{9}/|max:16',
            'address' => 'required|min:3',
            'email' => 'required|min:3|unique:users,email',
            'district_id' => 'required',
            'ward_id' => 'required',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'package_id' => 'required',
        ]);

        $userMeta = UserMeta::create([
            'address' => $data['address'],
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
            'status' => "Antrian",
            'date_install' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->format('Y-m-d H:i:s'),
            'user_id' => $user->id,
            'first_payment' => '1',
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
