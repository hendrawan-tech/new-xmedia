<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\UserHasInstallation;
use Illuminate\Http\Request;

class UserHasInstallationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $installations = Installation::orderBy('created_at', 'DESC')->get();
        $userHasInstallations = UserHasInstallation::pluck('installation_id')->all();
        $data = Installation::whereNotIn('id', $userHasInstallations)->whereNot('status', 'Aktif')->orderBy('created_at', 'DESC')->get();
        return view('employee.installation', compact('data', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $data = $request->validate([
            'installations' => 'required|array',
            'installations.*' => 'integer|exists:installations,id',
        ]);


        foreach ($data['installations'] as $item) {
            UserHasInstallation::create([
                'user_id' => $id,
                'installation_id' => $item,
            ]);
        }

        return redirect('user/employees')->with('success', 'Data Installasi Diupdate');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserHasInstallation $userHasInstallation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserHasInstallation $userHasInstallation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserHasInstallation $userHasInstallation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserHasInstallation $userHasInstallation)
    {
        //
    }
}
