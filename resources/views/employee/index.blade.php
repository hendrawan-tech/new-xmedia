@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Teknisi</h6>
                    <a href="/user/employees/create" class="btn btn-primary">+ Teknisi</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ Helper::time($item->created_at) }}</td>
                                        <td class="text-center">
                                            <a href="/user/employees/{{ $item->id }}/invoice"
                                                class="btn btn-sm btn-success btn-circle">
                                                <i class="fas fa-receipt"></i>
                                            </a>
                                            <a href="/user/employees/{{ $item->id }}/installation"
                                                class="btn btn-sm btn-primary btn-circle">
                                                <i class="fas fa-cogs"></i>
                                            </a>
                                            <a onclick='modal_konfir("/user/employees/{{ $item->id }}")' href="#"
                                                class="btn btn-sm btn-danger btn-circle">
                                                <i class="fa fa-trash"></i>
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
