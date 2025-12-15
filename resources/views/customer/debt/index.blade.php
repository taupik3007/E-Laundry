@extends('customer.master')

@push('link')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
E-Laundry | Daftar Piutang
@endsection

@section('content')
<div class="datatables">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Piutang</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Daftar Piutang</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/trolli.png') }}" alt="img" class="img-fluid mb-n4"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <h4 class="card-title mb-3">Daftar Piutang</h4>

            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Total Tagihan</th>
                            <th>Sudah Dibayar</th>
                            <th>Sisa Utang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($debts as $no => $payment)
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>{{ $payment->order->ord_invoice }}</td>
                            <td>{{ $payment->order->ord_customer_name }}</td>
                            <td>Rp {{ number_format($payment->pym_amount_paid) }}</td>
                            <td>Rp {{ number_format($payment->pym_amount) }}</td>
                            <td>Rp {{ number_format($payment->pym_debt_amount) }}</td>
                            <td>
                                <button class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalBayar{{ $payment->pym_id }}">
                                    Bayar Utang
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Total Tagihan</th>
                            <th>Sudah Dibayar</th>
                            <th>Sisa Utang</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL PEMBAYARAN ================== --}}
@foreach ($debts as $payment)
<div class="modal fade" id="modalBayar{{ $payment->pym_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('debt.update', $payment->pym_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran Utang via QRIS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>Total Utang</label>
                    <input type="text" class="form-control mb-3"
                        value="Rp {{ number_format($payment->pym_debt_amount) }}" readonly>
                        <p class="mt-2 text-danger">Metode Cash Tidak Tersedia</p>
                    {{-- QRIS SECTION --}}
                    <div class="text-center">
                        <p class="mt-2">Scan QRIS untuk membayar</p>
                        <img src="{{ asset('assets/images/backgrounds/OIP.jpg') }}"
                             class="img-fluid" style="max-width:250px;">
                        <p class="text-muted mt-2">Tunjukkan bukti pembayaran ke admin</p>
                    </div>
                    <p class="mt-2 text-danger">Untuk pembayaran cash, silakan datang langsung ke laundry ya 😊</p>
                    {{-- Kirim nilai total otomatis --}}
                    <input type="hidden" name="amount" value="{{ $payment->pym_debt_amount }}">
                    <input type="hidden" name="payment_method" value="qris">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Konfirmasi Pembayaran</button>
                </div>

            </form>

        </div>
    </div>
</div>



<script>
    document.getElementById('modalBayar').addEventListener('shown.bs.modal', function () {
        Swal.fire({
            icon: "warning",
            title: "Metode Cash Tidak Tersedia",
            text: "Untuk pembayaran cash, silakan datang langsung ke toko ya 😊",
            confirmButtonText: "Mengerti"
        });
    });
    </script>
    

@endforeach
@endsection


@push('script')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
{{-- HITUNG TOTAL UTANG --}}
{{-- <script>
$(document).ready(function () {
    var table = $('#file_export').DataTable({
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            var parseValue = value => parseInt(String(value).replace(/[^\d]/g, "")) || 0;

            var total = api.column(5, { search: "applied" })
                .data()
                .reduce((a, b) => parseValue(a) + parseValue(b), 0);

            $("#total-utang-footer").html("Total Utang : Rp " + total.toLocaleString("id-ID"));
        }
    });
});
</script> --}}
@endpush
