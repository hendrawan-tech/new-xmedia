<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $invoices = $user->role == 'admin' ? Invoice::orderBy('created_at', 'DESC')->get() : Invoice::where('user_id', Auth::user()->id)->get();
        if ($user->role == 'admin') {
            return view('invoice.index', compact('invoices'));
        } else {
            return view('invoice', compact('invoices'));
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('invoice.detail', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return view('invoice.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update($request->validate([
            'status' => 'required',
            'price' => 'required|numeric|min:1',
        ]));

        return redirect('/invoices')->with('success', 'Tagihan Diubah');
    }

    public function confirm(Request $request)
    {
        $invoice = Invoice::where('id', $request->invoice_id)->first();

        $installation = Installation::where('user_id', $invoice->user_id)->first();

        $installation->update([
            'end_date' => Carbon::now()->addMonth()->startOfMonth(),
            'first_payment' => '2',
        ]);

        $invoice->update([
            'status' => "Lunas",
        ]);

        return redirect()->back()->with('success', 'Tagihan Dikonfirmasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
