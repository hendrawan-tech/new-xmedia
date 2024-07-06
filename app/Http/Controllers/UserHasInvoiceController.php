<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\UserHasInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserHasInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $invoices = Invoice::orderBy('created_at', 'DESC')->whereNull('deleted_at')->get();
        $userHasInvoices = UserHasInvoice::pluck('invoice_id')->all();
        $data = Invoice::whereNotIn('id', $userHasInvoices)->where('status', 'Belum Lunas')->orderBy('created_at', 'DESC')->get();

        return view('employee.invoice', compact('data', 'id'));
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
        // Ambil data tagihan dari local storage jika tersedia
        $selectedInvoices = json_decode($request->input('selectedInvoices'), true) ?? [];

        // Validasi data dari local storage
        $validator = Validator::make(['invoices' => $selectedInvoices], [
            'invoices' => 'required|array',
            'invoices.*' => 'integer|exists:invoices,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data tagihan yang sudah divalidasi
        foreach ($selectedInvoices as $item) {
            UserHasInvoice::create([
                'user_id' => $id,
                'invoice_id' => $item,
            ]);
        }

        // Hapus data dari local storage setelah disimpan ke database
        // (Opsional: jika menggunakan session untuk menyimpan selectedInvoices)
        // $request->session()->forget('selectedInvoices');

        return redirect('user/employees')->with('success', 'Data Tagihan Diupdate');
    }


    /**
     * Display the specified resource.
     */
    public function show(UserHasInvoice $userHasInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserHasInvoice $userHasInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserHasInvoice $userHasInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserHasInvoice $userHasInvoice)
    {
        //
    }
}
