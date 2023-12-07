@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktif Sampai</h6>
                </div>
                <div class="card-body">
                    {{ Helper::time(Auth::user()->installations->end_date) }}
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="m-0">
                                ID Pelanggan
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->xmedia_id }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="m-0">
                                Paket Layanan
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->package->name }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="m-0">
                                No Telepon
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->phone }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="m-0">
                                Provinsi
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->province_name }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="m-0">
                                Kabupaten
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->regencies_name }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="m-0">
                                Kecamatan
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->district_name }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="m-0">
                                Keluarahan/Desa
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->ward_name }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="m-0">
                                Alamat
                            </p>
                            <p>
                                <b>{{ Auth::user()->userMeta->address }}</b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
