@extends('employee.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
@endpush

@section('title')
    E-Laundry Garut | Dashboard
@endsection

@section('content')
    <div class="owl-carousel counter-carousel owl-theme">
        <div class="item">
            <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../assets/images/svgs/icon-user-male.svg" width="50" height="50" class="mb-3"
                            alt="modernize-img" />
                        <p class="fw-semibold fs-3 text-primary mb-1">
                            Member
                        </p>
                        <h5 class="fw-semibold text-primary mb-0">{{ $member }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../assets/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3"
                            alt="modernize-img" />
                        <p class="fw-semibold fs-3 text-warning mb-1">Layanan</p>
                        <h5 class="fw-semibold text-warning mb-0">{{ $service }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../assets/images/svgs/icon-mailbox.svg" width="50" height="50" class="mb-3"
                            alt="modernize-img" />
                        <p class="fw-semibold fs-3 text-info mb-1">Pesanan</p>
                        <h5 class="fw-semibold text-info mb-0">{{ $order }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../assets/images/svgs/icon-favorites.svg" width="50" height="50" class="mb-3"
                            alt="modernize-img" />
                        <p class="fw-semibold fs-3 text-danger mb-1">Total Pesanan </p>
                        <h5 class="fw-semibold text-danger mb-0">{{ $orderDone }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../assets/images/svgs/icon-speech-bubble.svg" width="50" height="50" class="mb-3"
                            alt="modernize-img" />
                        <p class="fw-semibold fs-3 text-success mb-1">Piutang</p>
                        <h5 class="fw-semibold text-success mb-0">
                            {{ $creditCount }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="item">
            <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../assets/images/svgs/icon-connect.svg" width="50" height="50" class="mb-3"
                            alt="modernize-img" />
                        <p class="fw-semibold fs-3 text-info mb-1">Reports</p>
                        <h5 class="fw-semibold text-info mb-0">59</h5>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
                <div class="card-body position-relative">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex align-items-center mb-7">
                                <div class="rounded-circle overflow-hidden me-6">
                                    <img src="../assets/images/profile/user-1.jpg" alt="modernize-img" width="40"
                                        height="40">
                                </div>
                                <h5 class="fw-semibold mb-0 fs-5">Selamat Datang {{ Auth()->user()->usr_name }} !</h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="border-end pe-4 border-muted border-opacity-10">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                                        {{ 'Rp ' . number_format($todaySales, 0, ',', '.') }},-
                                        <i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                                    </h3>
                                    <p class="mb-0 text-dark">Pemasukan Hari ini</p>
                                </div>
                                <div class="ps-4">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">
                                        {{ 'Rp ' . number_format($monthlySales, 0, ',', '.') }},-<i
                                            class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                                    </h3>
                                    <p class="mb-0 text-dark">Pemasukan Bulan ini</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="welcome-bg-img mb-n7 text-end">
                                <img src="../assets/images/backgrounds/welcome-bg.svg" alt="modernize-img"
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-sm-12 col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h4 class="fw-semibold">$10,230</h4>
                    <p class="mb-2 fs-3">Expense</p>
                    <div id="expense"></div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div>
                        <h4 class="card-title fw-semibold mb-1">
                            Grafik Pemasukan
                        </h4>
                        <p class="card-subtitle">Bulanan</p>
                        <div id="salary" class="mb-7 pb-8 mx-n4"></div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div
                                    class="bg-primary-subtle rounded me-8 p-8 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots text-primary fs-6"></i>
                                </div>
                                <div>
                                    <p class="fs-3 mb-0 fw-normal">Salary</p>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0">
                                        $36,358
                                    </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div
                                    class="text-bg-light rounded me-8 p-8 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots text-muted fs-6"></i>
                                </div>
                                <div>
                                    <p class="fs-3 mb-0 fw-normal">Profit</p>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0">
                                        $5,296
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-6 col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div>
                        <h4 class="card-title fw-semibold">Grafik Penjualan</h4>
                        <p class="card-subtitle">Bulanan</p>
                        <div id="salary" class="mb-7 pb-8 mx-n4"></div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div
                                    class="bg-primary-subtle text-primary rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <p class="fs-3 mb-0 fw-normal">Bulan ini</p>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0">Rp.{{ $currentIncome }},-</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div
                                    class="bg-light-subtle text-muted rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <p class="fs-3 mb-0 fw-normal">Bulan Sebelumnya</p>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0">Rp.{{ $previousIncome }},-</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="p-2 bg-info-subtle rounded-2 d-inline-block mb-3">
                                <img src="../assets/images/svgs/icon-bar.svg" alt="modernize-img" class="img-fluid"
                                    width="24" height="24">
                            </div>
                            {{-- <div id="growth" class="mb-3"></div> --}}
                            <h4 class="mb-1 fw-semibold d-flex align-content-center">{{ $percentage }}%
                                @if ($percentage >= 0)
                                    <i class="ti ti-arrow-up-right fs-5 text-success"></i>
                                @else
                                    <i class="ti ti-arrow-down-right fs-5 text-danger"></i>
                                @endif
                            </h4>
                            <p class="mb-0">Growth</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="p-2 bg-primary-subtle rounded-2 d-inline-block mb-3">
                                <i class="ti ti-receipt-2 fs-5 text-danger" width="24" height="24"></i>
                            </div>
                            {{-- <div id="sales-two" class="mb-3 mx-n4"></div> --}}
                            <h4 class="mb-1 fw-semibold d-flex align-content-center">Rp.
                                {{ number_format($credit / 1000, 0) . 'K' }}
                                {{-- <i class="ti ti-arrow-down-right fs-5 text-danger"></i> --}}
                            </h4>
                            <p class="mb-0">Piutang</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row alig n-items-start">
                        <div class="col-8">
                            <h4 class="card-title mb-9 fw-semibold"> Pemasukan Mingguan </h4>
                            <div class="d-flex align-items-center mb-3">
                                @php
                                    $weekTotals = end($totals);
                                @endphp
                                <h4 class="fw-semibold mb-0 me-8">Rp. {{ number_format($weekTotals, 0, ',', '.') }},-</h4>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="me-2 rounded-circle bg-success-subtle text-success round-20 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-arrow-up-left"></i>
                                    </span>
                                    <p class="text-dark me-1 fs-3 mb-0">{{$growth}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="p-2 bg-primary-subtle rounded-2 d-inline-block">
                                    <img src="../assets/images/svgs/icon-master-card-2.svg" alt="modernize-img"
                                        class="img-fluid" width="24" height="24">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="monthly-earning"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">

                    <h4 class="card-title mb-0">Daftar Pesanan</h4>

                </div>
                <p class="card-subtitle mb-3">

                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">

                        <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Customer</th>
                                <th>Jenis Layanan</th>
                                <th>Berat/Unit</th>
                                <th>Total</th>
                                <th>Tanggal Selesai</th>

                            </tr>
                        </thead>
                        <tbody id="order-history-body">
                            {{-- @include('employee.order-laundry.history-table') --}}
                        </tbody>
                        <tfoot>
                            <!-- start row -->


                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Customer</th>
                                <th>Jenis Layanan</th>
                                <th>Berat/Unit</th>
                                <th>Total</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>



    <script>
        const months = @json($months); // ["Jul","Aug","Sep","Oct","Nov","Dec"]
        const totals = @json($totals); // [10000,20000,15000,...]
    </script>
@endsection



@push('script')
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards/employee.js') }}"></script>
    {{-- <script src="{{asset('assets/js/dashboards/dashboard.js')}}"></script> --}}

    <script>
        var options = {
            chart: {
                id: "weekly-earning",
                type: "area",
                height: 56,
                sparkline: {
                    enabled: true,
                },
                group: "sparklines",
                fontFamily: "inherit",
                foreColor: "#adb0bb",
            },

            // DATA WEEKLY (DINAMIS)
            series: [{
                name: "Weekly Earnings",
                color: "var(--bs-primary)",
                data: @json($totals), // <— TOTAL UANG PER MINGGU
            }, ],

            stroke: {
                curve: "smooth",
                width: 2,
            },

            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 0,
                    inverseColors: false,
                    opacityFrom: 0.1,
                    opacityTo: 0,
                    stops: [20, 180],
                },
            },

            markers: {
                size: 0,
            },

            tooltip: {
                theme: "dark",
                fixed: {
                    enabled: true,
                    position: "right",
                },
                x: {
                    show: true,
                    formatter: function(_, {
                        dataPointIndex
                    }) {
                        return @json($weeks)[dataPointIndex];
                        // contoh: "01 - 07"
                    }
                },
                y: {
                    formatter: function(value) {
                        return "Rp " + value.toLocaleString("id-ID");
                    }
                }
            },
        };

        new ApexCharts(document.querySelector("#monthly-earning"), options).render();
    </script>
@endpush
