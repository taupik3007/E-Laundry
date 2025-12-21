@extends('customer.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')

E-Laundry | Daftar Riwayat Laundry
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">RIWAYAT LAUNDRY</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="/employee/ordering/create">Dashboard</a>
                      </li>
                    <li class="breadcrumb-item" aria-current="page">Riwayat Laundry</li>
                    <li class="breadcrumb-item" aria-current="page">Detail Pesanan</li>

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
        
         {{-- FILTER RANGE --}}
         <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
              <h6 class="fw-semibold mb-3">Filter Rentang Tanggal</h6>

              <form action="" method="GET">
                  <div class="row g-3">

                      <div class="col-md-4">
                          <label class="form-label">Dari Tanggal</label>
                          <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" >
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Sampai Tanggal</label>
                          <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                      </div>

                      <div class="col-md-4 d-flex align-items-end">
                          <button class="btn btn-primary me-2" type="submit">Filter</button>
                          <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('laundry-order.history') }}'">Reset</button>
                      </div>

                  </div>
                  <br>
                  <span class="badge bg-primary px-3 py-2 fs-5">
                    Total Pengeluaran: Rp {{ number_format($history->sum('ord_total'), 0, ',', '.') }}
                  </span>
              </form>
          </div>
      </div>
    
        
        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">

                    <h4 class="card-title mb-0">Riwayat Laundry</h4>
                   
                </div>
                <p class="card-subtitle mb-3">
                    
                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">

      <thead>
        <tr>
          <th width="10%">No</th>
          <th>Invoice</th>
          <th width="20%">Nama Customer</th>
          <th>Total</th>
          <th>Tanggal Selesai</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($history as $no => $order)
          <tr>
            <td>{{ $no + 1 }}</td>
            <td>{{ $order->ord_invoice ?? '-' }}</td>
            <td>{{ $order->ord_customer_name }}</td>
            {{-- <td>{{ $order->service->lds_name ?? '-' }}</td>
            <td>{{ $order->ord_quantity ?? '-' }} {{ $order->package->ldp_unit ?? '-' }}</td> --}}
            <td>
                Rp
                {{ number_format($order->ord_total ?? $order->details->sum('odt_total'), 0, ',', '.') }}
        
            </td>
            <td>{{ $order->ord_updated_at->format('d/m/Y H:i') }}</td>
            <td>
              <a href="/customer/laundry-order/history/{{ $order->ord_id}}/detail" class="btn btn-warning">Detail</a>
            </td>
          </tr>
        @endforeach 
      </tbody>
      
    <tfoot>
        <!-- start row -->
        

        <tr>
          <th width="10%">No</th>
            <th>Invoice</th>
            <th width="20%">Nama Customer</th>
            <th>Total</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
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
