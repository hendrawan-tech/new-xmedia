@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Pelanggan</h6>
                </div>
                <div class="card-body">
                    <form action="/user/clients" method="POST">
                        @csrf
                        <input type="hidden" name="district_name">
                        <input type="hidden" name="ward_name">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>ID X Media</label>
                                    <input type="text" class="form-control @error('xmedia_id') is-invalid @enderror"
                                        name="xmedia_id" value="{{ old('xmedia_id') }}">
                                    @error('xmedia_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        name="nik" value="{{ old('nik') }}">
                                    @error('nik')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>No Hp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>Paket Internet</label>
                                    <select class="form-control @error('package_id') is-invalid @enderror"
                                        name="package_id">
                                        <option value="">Pilih Paket Internet</option>
                                        @foreach ($packages as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == old('package_id') ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('package_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror status-select"
                                        name="status">
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Antrian">Belum Aktif</option>
                                    </select>
                                    @error('status')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select id="district" class="form-control @error('district_id') is-invalid @enderror"
                                        name="district_id">
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach ($district as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == old('district_id') ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label>Kelurahan / Desa</label>
                                    <select id="ward" class="form-control @error('ward_id') is-invalid @enderror"
                                        name="ward_id">
                                        <option value="">Pilih Keluarahan / Desa</option>
                                    </select>
                                    @error('ward_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row tanggal-section d-none">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal Pemasangan</label>
                                    <input type="date" class="form-control @error('date_install') is-invalid @enderror"
                                        name="date_install" value="{{ old('date_install') }}">
                                    @error('date_install')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal Aktif</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        name="end_date" value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="text" class="form-control @error('rt') is-invalid @enderror"
                                        name="rt" value="{{ old('rt') }}">
                                    @error('rt')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>RW</label>
                                    <input type="text" class="form-control @error('rw') is-invalid @enderror"
                                        name="rw" value="{{ old('rw') }}">
                                    @error('rw')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" cols="30" rows="4">{{ old('address') }}</textarea>
                            @error('address')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                $('.status-select').change(function() {
                    var selectedStatus = $(this).val();
                    if (selectedStatus === 'Aktif') {
                        $('.tanggal-section').removeClass('d-none');
                    } else {
                        $('.tanggal-section').addClass('d-none');
                    }
                });

                $('#district').change(function() {
                    var districtId = $(this).val();
                    var districtName = $(this).find('option:selected')
                        .text();

                    $('input[name="district_name"]').val(districtName);

                    $.ajax({
                        url: `/api/ward?district_id=${districtId}`,
                        type: 'GET',
                        success: function(response) {
                            var wards = response.data;

                            var wardSelect = $('#ward');
                            wardSelect.empty();
                            wardSelect.append('<option value="">Pilih Kelurahan / Desa</option>');
                            $.each(wards, function(key, ward) {
                                wardSelect.append('<option value="' + ward.id + '">' + ward
                                    .nama + '</option>');
                            });
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                });

                $('#ward').change(function() {
                    var wardName = $(this).find('option:selected').text();
                    $('input[name="ward_name"]').val(wardName);
                });
            });
        </script>
    @endpush
@endsection
