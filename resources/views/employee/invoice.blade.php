@extends('layouts.app')

@section('content')
    @php
        $selectedInvoices = [];
    @endphp
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Tagihan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="/user/employees/{{ $id }}/invoice" method="POST" id="invoiceForm">
                                @csrf
                                <input type="hidden" name="selectedInvoices" id="selectedInvoices"
                                    value="{{ json_encode($selectedInvoices) }}">
                                <label for="invoices" class="form-label">
                                    Pilih Tagihan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="table-responsive table-card m-1">
                                    <table class="table table-nowrap table-striped-columns mb-0" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Pilih</th>
                                                <th scope="col">User</th>
                                                <th scope="col">ID Invoice</th>
                                                <th scope="col">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $item)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $item->id }}" name="invoices[]"
                                                                id="cardtableCheck{{ $key + 1 }}">
                                                            <label class="form-check-label"
                                                                for="cardtableCheck{{ $key + 1 }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ $item->external_id }}</td>
                                                    <td>{{ $item->price }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if ($errors->has('invoices'))
                                    @foreach ($errors->get('invoices') as $error)
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

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectedInvoicesInput = document.getElementById('selectedInvoices');
            let selectedInvoices = JSON.parse(selectedInvoicesInput.value) || [];

            const checkboxes = document.querySelectorAll('input[name="invoices[]"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectedInvoices.push(this.value);
                    } else {
                        const index = selectedInvoices.indexOf(this.value);
                        if (index !== -1) {
                            selectedInvoices.splice(index, 1);
                        }
                    }
                    selectedInvoicesInput.value = JSON.stringify(selectedInvoices);
                });
            });
        });
    </script>
@endpush
