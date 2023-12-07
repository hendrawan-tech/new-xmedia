@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Promo</h6>
                    <a href="/content/promos/create" class="btn btn-primary">+ Promo</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Gambar</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <div class="images" style="width: 70px; height: 40px;">
                                                <img src="{{ asset($item->image) }}" alt=""
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td>{{ Helper::time($item->created_at) }}</td>
                                        <td class="text-center">
                                            <a href="/content/promos/{{ $item->id }}/edit"
                                                class="btn btn-sm btn-primary btn-circle mr-2">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            <a onclick='modal_konfir("/content/promos/{{ $item->id }}")' href="#"
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
