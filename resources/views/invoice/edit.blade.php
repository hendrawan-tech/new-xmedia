@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Tagihan</h6>
                </div>
                <div class="card-body">
                    <form action="/invoices/{{ $invoice->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control @error('name') is-invalid @enderror" name="status">
                                <option value="PENDING" {{ $invoice->status == 'PENDING' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="SUCCESS" {{ $invoice->status == 'SUCCESS' ? 'selected' : '' }}>Success
                                </option>
                            </select>
                            @error('status')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                value="{{ $invoice->price }}">
                            @error('price')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
