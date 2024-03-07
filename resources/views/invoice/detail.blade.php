@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <div class="text-primary font-weight-bold">Invoice</div>
                    <strong>{{ $invoice->external_id }}</strong>
                    <span class="float-right"> <strong>Status:</strong> {{ $invoice->status }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">Metode Pembayaran</h6>
                            <div>Bank: {{ $invoice->payment->bank_name ?? '-' }}</div>
                            <div>No Rekening: {{ $invoice->payment->bank_number ?? '-' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="mb-3">Pengguna</h6>
                            <div>
                                <strong> {{ $invoice->user->name }}</strong>
                            </div>
                            <div>Email: {{ $invoice->user->email }}</div>
                            <div>No Telepon: {{ $invoice->user->userMeta->phone }}</div>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Paket Internet</th>
                                    <th>Kecepatan</th>
                                    <th class="right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center">1</td>
                                    <td class="left strong">
                                        {{ $invoice->user->userMeta->package->name }}
                                    </td>
                                    <td class="left">{{ $invoice->user->userMeta->package->speed }}</td>
                                    <td class="right">
                                        {{ Helper::price($invoice->user->userMeta->package->price) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-5">

                        </div>

                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                    <tr>
                                        <td class="left">
                                            <strong>Total</strong>
                                        </td>
                                        <td class="right">
                                            <strong>{{ Helper::price($invoice->price) }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($invoice->status != 'Belum Lunas')
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        Bukti Pembayaran
                                    </div>
                                    <img class="my-5 w-50 mx-auto" src="{{ asset($invoice->image) }}" class="img-thumbnail"
                                        alt="">
                                    @if ($invoice->status == 'Proses')
                                        <form action="/invoices/confirm" method="POST">
                                            @csrf
                                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                            <button class="btn m-2 w-100 btn-primary" type="submit">Konfirmasi
                                                Pembayaran</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
