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
                        <h4 class="fw-semibold mb-8">History PEMESANAN LAUNDRY</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Daftar Pesanan</li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/employee/ordering/create">Tambah
                                        Pesanan</a>
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
                            <img src="{{ asset('assets/images/breadcrumb/trolli.png') }}" alt="modernize-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">

                    <h4 class="card-title mb-0">Daftar History Pesanan</h4>
                 

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
                               

                            </tr>

                            <!-- end row -->
                        </thead>
                        <tbody>
                            @foreach ($orderlist as $no => $order)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $order->ord_customer_name }}</td>
                                    <td>{{ $order->service->lds_name ?? '-' }} Paket {{ $order->package->ldp_name ?? '-' }}
                                    </td>
                                    <td>{{ $order->ord_quantity ?? '-' }} {{ $order->package->ldp_unit ?? '-' }}</td>
                                    <td>
                                        Rp
                                        {{ number_format($order->ord_total ?? $order->package->ldp_price * $order->ord_quantity, 0, ',', '.') }}
                                    </td>
                                   

                                  
                                </tr>
                                <div class="modal fade" id="modalTimbang{{ $order->ord_id }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST"
                                                action="{{ route('order.updateWeight', $order->ord_id) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Input Timbangan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        {{-- <label>Jumlah ({{ $order->package->ldp_unit ?? '-' }})</label>
                                      <input type="number" step="0.1" name="ord_quantity" class="form-control" value="{{ $order->ord_quantity }}">
                                       --}}

                                                        <label>Jumlah ({{ $order->package->ldp_unit ?? '-' }})</label>
                                                        <input type="number" step="0.1"
                                                            id="quantity{{ $order->ord_id }}" name="ord_quantity"
                                                            class="form-control mb-2" value="{{ $order->ord_quantity }}"
                                                            oninput="hitungTotal{{ $order->ord_id }}()">

                                                        <label>Harga per {{ $order->package->ldp_unit ?? '' }}</label>
                                                        <input type="text" class="form-control mb-2"
                                                            value="Rp {{ number_format($order->package->ldp_price, 0, ',', '.') }}"
                                                            readonly>

                                                        <label>Total Harga</label>
                                                        <input type="text" id="totalHarga{{ $order->ord_id }}"
                                                            class="form-control" readonly>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <script>
                                        function hitungTotal{{ $order->ord_id }}() {
                                            let qty = parseFloat(document.getElementById("quantity{{ $order->ord_id }}").value) || 0;
                                            let price = {{ $order->package->ldp_price }};
                                            let total = qty * price;

                                            document.getElementById("totalHarga{{ $order->ord_id }}").value =
                                                "Rp " + total.toLocaleString("id-ID");
                                        }

                                        // jalankan awal kali load
                                        hitungTotal{{ $order->ord_id }}();
                                    </script>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <!-- start row -->


                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Customer</th>
                                <th>Jenis Layanan</th>
                                <th>Berat/Unit</th>
                                <th>Total</th>
                                
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="modal fade" id="modalTimbang{{ $order->ord_id }}">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form method="POST" action="{{ route('order.updateWeight', $order->ord_id) }}">
          @csrf
          @method('PUT')
    
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Input Timbangan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
    
            <div class="modal-body">
              {{-- <label>Jumlah ({{ $order->package->ldp_unit ?? '-' }})</label>
              <input type="number" step="0.1" name="ord_quantity" class="form-control" value="{{ $order->ord_quantity }}">
               

              <label>Jumlah ({{ $order->package->ldp_unit ?? '-' }})</label>
              <input type="number" step="0.1" id="quantity{{ $order->ord_id }}" name="ord_quantity"
                      class="form-control mb-2"
                      value="{{ $order->ord_quantity }}" oninput="hitungTotal{{ $order->ord_id }}()">

              <label>Harga per {{ $order->package->ldp_unit ?? '' }}</label>
              <input type="text" class="form-control mb-2"
                     value="Rp {{ number_format($order->package->ldp_price, 0, ',', '.') }}"
                     readonly>

              <label>Total Harga</label>
              <input type="text" id="totalHarga{{ $order->ord_id }}" class="form-control"
                            readonly>
            </div>
    
            <div class="modal-footer">
              <button class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div> --}}
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

    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>

    
@endpush
