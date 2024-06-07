<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::orderBy('created_at', 'DESC')->get();
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:5',
            'bank_name' => 'required|min:5',
            'bank_number' => 'required|min:5',
            'logo' => 'file|between:0,2048|mimes:jpeg,jpg,png',
        ]);

        if ($request->logo) {
            $filetype = $request->file('logo')->extension();
            $text = Str::random(16) . '.' . $filetype;
            $data['logo'] = Storage::putFileAs('postImage', $request->file('logo'), $text);
        }

        Payment::create($data);

        return redirect('/payments')->with('success', 'Metode Pembayaran Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return view('payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'name' => 'required|min:5',
            'bank_name' => 'required|min:5',
            'bank_number' => 'required|min:5',
            'logo' => 'file|between:0,2048|mimes:jpeg,jpg,png',
        ]);

        if ($request->logo) {
            // if ($payment->logo !== null) {
            //     Storage::delete($payment->image);
            // }
            $filetype = $request->file('logo')->extension();
            $text = Str::random(16) . '.' . $filetype;
            $data['logo'] = Storage::putFileAs('postImage', $request->file('logo'), $text);
        }

        $payment->update($data);

        return redirect('/payments')->with('success', 'Metode Pembayaran Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect('/payments')->with('success', 'Metode Pembayaran Dihapus');
    }
}
