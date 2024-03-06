@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Installasi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="/user/employees/{{ $id }}/installation" method="POST">
                                @csrf
                                <label for="installations" class="form-label">
                                    Pilih Installasi
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="table-responsive table-card m-1">
                                    <table class="table table-nowrap table-striped-columns mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Pilih</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Tanggal Dibuat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $item)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $item->id }}" name="installations[]"
                                                                id="cardtableCheck{{ $key + 1 }}}">
                                                            <label class="form-check-label"
                                                                for="cardtableCheck{{ $key + 1 }}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ Helper::time($item->created_at) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if ($errors->has('installations'))
                                    @foreach ($errors->get('installations') as $error)
                                        <div class="invalid-feedback d-block">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
                                <div class="d-flex justify-content-end mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
