@extends('employee.master')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title', 'E-Laundry Garut | Pengeluaran')

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
            <h4 class="fw-semibold mb-8">PENGELUARAN</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a  class="text-muted text-decoration-none" href="/employee/ordering">Daftar Pemasukan dan Pengeluaran</a>
            </li>
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none">Tambah Pengeluaran</a>
                </li>
              </ol>
             
            </nav>
          </div>
        <div class="col-3">
          <div class="text-center mb-n5">
            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="datatables" style="padding: 25px">
    {{-- Filter Tahun --}}
    <ul class="nav nav-tabs" id="yearTabs">
        @foreach ([2025, 2024, 2023] as $tahun)
            <li class="nav-item">
                <button class="nav-link year-tab {{ $selectedYear == $tahun ? 'active' : '' }}" data-year="{{ $tahun }}">{{ $tahun }}</button>
            </li>
        @endforeach
    </ul>

    {{-- Filter Bulan --}}
    @php
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp

    <div class="mt-3 d-flex flex-wrap gap-2" id="monthButtons">
        @foreach ($bulanList as $no => $namaBulan)
            <button class="btn btn-sm month-btn {{ $selectedMonth == $no ? 'btn-primary' : 'btn-outline-primary' }}" data-month="{{ $no }}">{{ $namaBulan }}</button>
        @endforeach
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="mb-5 position-relative">
                <h4 class="card-title mb-0">Order Laundry</h4>
                <a href="/employee/expenditure/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Pengeluaran</a>
            </div>

            <div class="table-responsive">
                <table id="financeTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot class="fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Total</td>
                            <td class="text-end" id="totalPemasukan">Rp0</td>
                            <td class="text-end" id="totalPengeluaran">Rp0</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Saldo Akhir</td>
                            <td colspan="2" class="text-end" id="saldoAkhir">Rp0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('script')
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<!-- Wajib: script tombol DataTables -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
let selectedYear = {{ $selectedYear }};
let selectedMonth = {{ $selectedMonth }};
let table;

$(document).ready(function () {
    table = $('#financeTable').DataTable({
        dom: "<'row mb-2 align-items-center'<'col-md-6 d-flex gap-2'B><'col-md-6 text-end'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
        
             buttons: [
            {
                text: '<i class="bi bi-download"></i> Download PDF Arus Kas',
                className: 'btn btn-primary',
                action: function () {
                    const url = ``;
                    window.location.href = url
                        .replace('__YEAR__', selectedYear)
                        .replace('__MONTH__', selectedMonth);
                }
            }
        ],

        ajax: {
            url: '',
            data: function (d) {
                d.year = selectedYear;
                d.month = selectedMonth;
            },
            dataSrc: function (json) {
                $('#totalPemasukan').text('Rp' + json.total_masuk.toLocaleString('id-ID'));
                $('#totalPengeluaran').text('Rp' + json.total_keluar.toLocaleString('id-ID'));
                $('#saldoAkhir').text('Rp' + json.saldo_akhir.toLocaleString('id-ID'));
                return json.data;
            }
        },
        columns: [
            { data: null, render: (d, t, r, m) => m.row + 1 },
            { data: 'tanggal' },
            { data: 'keterangan' },
            { data: 'pemasukan', className: 'text-end' },
            { data: 'pengeluaran', className: 'text-end' },
            {
                data: null,
                render: function (data, type, row) {
                    return row.pengeluaran
                        ? `<button class="btn btn-sm btn-warning btn-edit" data-id="${data.id}" data-deskripsi="${data.keterangan}" data-jumlah="${data.raw_jumlah}" data-kategori="${data.kategori}">Edit</button>`
                        : '';
                },
                orderable: false
            }
        ]
    });

    // Filter Tahun
    $(document).on('click', '.year-tab', function () {
        selectedYear = $(this).data('year');
        $('.year-tab').removeClass('active');
        $(this).addClass('active');
        table.ajax.reload();
    });

    // Filter Bulan
    $(document).on('click', '.month-btn', function () {
        selectedMonth = $(this).data('month');
        $('.month-btn').removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        table.ajax.reload();
    });

    // Edit Pengeluaran
    $(document).on('click', '.btn-edit', function () {
        $('#edit_id').val($(this).data('id'));
        $('#edit_deskripsi').val($(this).data('deskripsi'));
        $('#edit_jumlah').val($(this).data('jumlah'));
        $('#edit_keterangan').val($(this).data('kategori'));
        $('#formEditPengeluaran').attr('action', `/treasurer/finance/expense/${$(this).data('id')}`);
        $('#modalEditPengeluaran').modal('show');
        
    });
});
</script>
@endpush
