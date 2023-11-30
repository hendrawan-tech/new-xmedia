@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Tagihan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $item)
                                    <tr>
                                        <td>{{ $item->external_id }}</td>
                                        <td>{{ Helper::price($item->price) }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ Helper::time($item->created_at) }}</td>
                                        <td>
                                            @if ($item->status == 'PENDING')
                                                <button onclick="openFrameModal('{{ $item->invoice_url }}')"
                                                    class="btn btn-primary btn-sm">Bayar Sekarang</button>
                                            @else
                                                Tidak Ada Aksi
                                            @endif
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

    <div class="modal fade" id="modalInvoice" tabindex="-1" role="dialog" aria-labelledby="modalInvoice"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInvoice">Pembayaran</h5>
                    <button type="button" class="close" onclick="closeModalAndReload()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openFrameModal(url) {
            var modal = $('#modalInvoice');
            var modalBody = modal.find('.modal-body');
            modalBody.html('<iframe src="' + url + '" style="width: 100%; height: 100%; border: none;"></iframe>');
            modal.modal('show');
        }

        function closeModalAndReload() {
            $('#exampleModal').modal('hide'); // Menutup modal
            location.reload(); // Me-reload halaman
        }
    </script>
@endsection
