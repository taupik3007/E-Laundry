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
       
        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">

                    <h4 class="card-title mb-0">Daftar Pesanan</h4>
                    <a href="/employee/ordering/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Pesanan</a>

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
                                <th>Status</th>
                                <th>Aksi</th>
                                
                            </tr>

                            <!-- end row -->
                        </thead>
                        <tbody>
                            @foreach($orderlist as $no => $order)
                              <tr>
                                <td>{{ $no + 1 }}</td>
                                <td></td>
                                <td>{{ $order->service->lds_name ?? '-' }} Paket {{ $order->package->ldp_name ?? '-' }}</td>
                                <td>{{ $order->ord_quantity ?? '-' }} {{ $order->package->ldp_unit ?? '-' }}</td>
                                <td>
                                  Rp {{ number_format($order->ord_total ?? ($order->package->ldp_price * $order->ord_quantity), 0, ',', '.') }}
                              </td>
                                <td class="d-flex align-items-center gap-2">
                                  <div class="dropdown">

                                    @php
                                      $color = match($order->ord_status) {
                                        'menunggu'              => 'btn-warning',
                                        'dalam penjemputan'     => 'btn-info',
                                        'menunggu penyerahan'   => 'btn-primary',
                                        'proses'                => 'btn-secondary',
                                        'dalam pengantaran'     => 'btn-info',
                                        'menunggu pengambilan'  => 'btn-primary',
                                        'selesai'               => 'btn-success',
                                        'Dibatalkan'            => 'btn-danger',
                                        default => 'btn-secondary'
                                      };
                                    @endphp
                                    <button class="btn {{ $color }} dropdown-toggle" type="button" id="statusDropdown{{ $order->ord_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $order->ord_status }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $order->ord_id }}">
                                      <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="menunggu">Menunggu</a></li>
                                      <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="dalam penjemputan">Dalam Penjemputan</a></li>
                                      <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="menunggu penyerahan">Menunggu Penyerahan</a></li>
                                      <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="proses">Proses</a></li>
                                      <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="dalam pengantaran">Dalam Pengantaran</a></li>
                                      <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="menunggu pengambilan">Menunggu Pengambilan</a></li>
                                      <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="selesai">Selesai</a></li>
                                      <li><a class="dropdown-item change-status text-danger" href="#" data-id="{{ $order->ord_id }}" data-status="Dibatalkan">Dibatalkan</a></li>
                                 
                                    </ul>
                                  </div>
                                </td>
                                
                                <td>
                                    <a href="/employee/ordering/{id}/edit" class="btn btn-primary">Edit</a>
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalTimbang{{ $order->ord_id }}">
                                      timbang
                                  </button>
                                  
                                    <a href="/employee/ordering/{id}/destroy" class="btn btn-danger" data-confirm-delete="true">Delete</a>
                               </td>
                            </tr>
                            @endforeach 
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            

                            <tr>
                              <th width="10%">No</th>
                              <th>Nama Customer</th>
                              <th>Jenis Layanan</th>
                              <th>Total</th>
                              <th>Status</th>
                              <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalTimbang{{ $order->ord_id }}">
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
               --}}

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

    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>

    <script>
      $(document).ready(function() {
        $('.change-status').on('click', function(e) {
          e.preventDefault();
      
          var orderId = $(this).data('id');
          var newStatus = $(this).data('status');
      
          $.ajax({
            url: '/employee/ordering/' + orderId + '/status',
            type: 'POST',
            data: {
              _token: '{{ csrf_token() }}',
              ord_status: newStatus
            },
            success: function(response) {
              if (response.success) {
                // ✅ Update teks & warna tombol status
                var statusButton = $('#statusDropdown' + orderId);
      
                // Peta warna status
                var colorMap = {
                  'Menunggu': 'btn-warning',
                  'Dalam Penjemputan': 'btn-info',
                  'Selesai': 'btn-success',
                  'Dibatalkan': 'btn-danger'
                };
      
                var newColor = colorMap[response.status] || 'btn-secondary';
      
                statusButton
                  .text(response.status)
                  .removeClass('btn-warning btn-info btn-success btn-danger btn-secondary')
                  .addClass(newColor);
      
                // ✅ Update tombol delete sesuai status baru
                var deleteBtn = $('a.delete-order[data-id="' + orderId + '"]');
                var deleteBtnDisabled = $('button[data-id="' + orderId + '"].btn-danger');
      
                if (response.status === 'Selesai' || response.status === 'Dibatalkan') {
                  // Jika delete button belum ada (karena disable), ubah jadi aktif
                  if (deleteBtnDisabled.length) {
                    deleteBtnDisabled.replaceWith(
                      '<a href="#" class="btn btn-danger delete-order" data-id="' + orderId + '">Delete</a>'
                    );
                  }
                } else {
                  // Jika status belum selesai/dibatalkan → disable tombol delete
                  if (deleteBtn.length) {
                    deleteBtn.replaceWith(
                      '<button class="btn btn-danger" disabled data-id="' + orderId + '">Delete</button>'
                    );
                  }
                }
              }
            },
            error: function(xhr) {
              alert('❌ Gagal mengubah status.');
            }
          });
        });
      });
      </script>
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

@endpush
