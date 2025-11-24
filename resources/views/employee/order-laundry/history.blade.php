@extends('employee.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')

E-Laundry Garut | Daftar Pemesanan
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">PEMESANAN LAUNDRY</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Daftar Pesanan</li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="/employee/ordering/create">Tambah Pesanan</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none">Edit Pesanan</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none">History Pesanan</a>
                      </li>

                    </ol>
                   
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">
                    <img src="{{ asset('assets/images/breadcrumb/trolli.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
        </div>
        
       <!-- TOMBOL FILTER TAHUN -->
<div class="btn-group mb-3" role="group">
    @foreach(range(date('Y'), 2022) as $year)
        <button class="btn btn-sm filter-year {{ request('year') == $year ? 'btn-primary' : 'btn-outline-primary' }}"
                data-year="{{ $year }}">
            {{ $year }}
        </button>
    @endforeach
</div>

<!-- TOMBOL FILTER BULAN -->
<div class="d-flex flex-wrap gap-2 mb-4">
    @foreach ([
        1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
        7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'
    ] as $num => $monthName)
        <button class="btn btn-sm filter-month {{ request('month') == $num ? 'btn-success' : 'btn-outline-success' }}"
                data-month="{{ $num }}">
            {{ $monthName }}
        </button>
    @endforeach
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
        @include('employee.order-laundry.history-table')
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

@endsection



@push('script')

<script>
    $(document).ready(function() {
    
        let table = $('#file_export').DataTable();
    
        function loadData(year = '', month = '') {
            $.ajax({
                url: "{{ route('order.history') }}",
                type: "GET",
                data: { year, month },
                success: function(res) {
                    table.clear().destroy();     // reset DataTable
                    $('#file_export tbody').html(res);   // replace rows
                    table = $('#file_export').DataTable();  // re-init DataTable
                }
            });
        }
    
        $('.filter-year').on('click', function() {
            let year = $(this).data('year');
            let month = $('.filter-month.btn-success').data('month') ?? '';
            loadData(year, month);
        });
    
        $('.filter-month').on('click', function() {
            let year = $('.filter-year.btn-primary').data('year') ?? '';
            let month = $(this).data('month');
            loadData(year, month);
        });
    
    });
    </script>
    
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>

    
    
@endpush
