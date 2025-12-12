@extends('owner.master')

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

            <form action="{{ route('debt-own.update', $payment->pym_id) }}" method="POST"> 
            {{-- <form action="" method="POST"> --}}
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran Utang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Total Utang</label>
                    <input type="text" class="form-control mb-3"
                        value="Rp {{ number_format($payment->pym_debt_amount) }}" readonly>

                    <label>Jumlah Bayar</label>
                    <input type="text" name="amount" id="bayar{{ $payment->pym_id }}"
                        class="form-control" oninput="formatBayar{{ $payment->pym_id }}(this)" required>

                    <label class="mt-3">Sisa Utang</label>
                    <input type="text" id="sisa{{ $payment->pym_id }}" class="form-control" readonly>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Konfirmasi Pembayaran</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
function formatBayar{{ $payment->pym_id }}(input) {
    let angka = input.value.replace(/[^0-9]/g, "");
    if (!angka) angka = 0;
    let total = {{ $payment->pym_debt_amount }};
    if (angka > total) {
        angka = total;
        alert("Jumlah bayar tidak boleh lebih dari sisa utang");
        input.value = "Rp " + angka.toLocaleString("id-ID"); // update input langsung
    }
    let sisa = total - angka;

    input.value = "Rp " + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    document.getElementById("sisa{{ $payment->pym_id }}").value =
        "Rp " + sisa.toLocaleString("id-ID");
}
</script>
@endforeach
@endsection


@push('script')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
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
