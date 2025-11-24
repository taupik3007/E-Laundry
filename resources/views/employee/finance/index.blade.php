@extends('employee.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    E-Laundry | Keuangan
@endsection

@section('content')
    <div class="datatables">

        {{-- HEADER --}}
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">KEUANGAN</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Keuangan</li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Rekap Pemasukan
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/breadcrumb/trolli.png')}}" alt="img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SUMMARY CARD --}}
        <div class="row mb-4">

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Pemasukan Hari Ini</h6>
                        <h3 class="fw-bold">Rp 75.000</h3>
                        <small class="text-muted">{{ date('d M Y') }}</small>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Pemasukan Bulan Ini</h6>
                        <h3 class="fw-bold">Rp 450.000</h3>
                        <small class="text-muted">Periode {{ date('F Y') }}</small>
                    </div>
                </div>
            </div>

        </div>

        {{-- FILTER RANGE --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Filter Rentang Tanggal</h6>

                <form action="" method="GET">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary me-2" type="submit">Filter</button>
                            <button type="button" class="btn btn-secondary"
                                onclick="window.location.reload()">Reset</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- TABEL KEUANGAN --}}
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3 fw-semibold">Rekap Pemasukan</h5>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100" id="keuanganTable">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>2025-11-25</td>
                                <td>#INV00123</td>
                                <td>Rizky</td>
                                <td>Cash</td>
                                <td>Rp 25.000</td>
                                <td><span class="badge bg-success">Lunas</span></td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>2025-11-25</td>
                                <td>#INV00124</td>
                                <td>Dinda</td>
                                <td>Transfer</td>
                                <td>Rp 30.000</td>
                                <td><span class="badge bg-success">Lunas</span></td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>2025-11-24</td>
                                <td>#INV00122</td>
                                <td>Aldi</td>
                                <td>QRIS</td>
                                <td>Rp 20.000</td>
                                <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#keuanganTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print'],
            });
        });
    </script>
@endpush
