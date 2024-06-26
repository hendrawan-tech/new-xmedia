@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Tagihan</h6>
                    {{-- <a href="/invoices/create" class="btn btn-primary">+ Tagihan</a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $item)
                                    <tr>
                                        <td>
                                            <a href="/invoices/{{ $item->id }}">{{ $item->external_id }}</a>
                                        </td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ Helper::price($item->price) }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ Helper::time($item->created_at) }}</td>
                                        <td class="text-center">
                                            <a href="/invoices/{{ $item->id }}/edit"
                                                class="btn btn-sm btn-primary btn-circle">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
