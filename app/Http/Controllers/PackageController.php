<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::orderBy('created_at', 'DESC')->get();
        return view('package.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:5',
            'price' => 'required|numeric',
            'speed' => 'required',
            'description' => 'required|min:5',
        ]);
        $data['month'] = "1 Bulan";
        Package::create($data);
        return redirect('/packages')->with('success', 'Paket Internet Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        return view('package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $data = $request->validate([
            'name' => 'required|min:5',
            'price' => 'required|numeric',
            'speed' => 'required',
            'description' => 'required|min:5',
        ]);
        $data['month'] = "1 Bulan";
        $package->update($data);
        return redirect('/packages')->with('success', 'Paket Internet Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect('/packages')->with('success', 'Paket Internet Dihapus');
    }
}
