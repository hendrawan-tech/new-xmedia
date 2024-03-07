@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">
    <style>
        .mce-notification.mce-in {
            display: none !important;
        }

        .dropify-wrapper .dropify-message p {
            font-size: 14px !important;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Metode Pembayaran</h6>
                </div>
                <div class="card-body">
                    <form action="/payments/{{ $payment->id }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Nama Pemilik <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" value="{{ $payment->name }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="Masukkan Nama Pemilik">
                                                    @error('name')
                                                        <span class="form-text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Nama Bank <span class="text-danger">*</span></label>
                                                    <input type="text" name="bank_name" value="{{ $payment->bank_name }}"
                                                        class="form-control @error('bank_name') is-invalid @enderror"
                                                        placeholder="Masukkan Nama Bank">
                                                    @error('bank_name')
                                                        <span class="form-text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Nomor Rekening <span class="text-danger">*</span></label>
                                                    <input type="text" name="bank_number"
                                                        value="{{ $payment->bank_number }}"
                                                        class="form-control @error('bank_number') is-invalid @enderror"
                                                        placeholder="Masukkan Nomor Rekening">
                                                    @error('bank_number')
                                                        <span class="form-text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group">
                                                    <label for="">Logo Bank</label>
                                                    <input type="file" id="input-file-now" name="logo" class="dropify"
                                                        data-default-file="{{ asset($payment->logo) }}" />
                                                    @error('logo')
                                                        <span class="form-text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary w-100" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/tinymce.js') }}"></script>
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/dropify.js') }}"></script>
@endpush
