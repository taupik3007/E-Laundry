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
                    <img src="{{ asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>
       
        <div class="card">
            <div class="card-body">
              <div class="mb-5 position-relative">

                <h4 class="card-title mb-0">Daftar Penjemputan</h4>
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
                                <th>No. Customer</th>
                                <th>Alamat Penjemputan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                
                            </tr>

                            <!-- end row -->
                        </thead>
                        <tbody>
                            @foreach($order as $no => $order)
                            <tr>
                              <td>{{ $no + 1 }}</td>
                                <td>{{ $order->ord_name_user }}</td>
                                <td>{{ $order->ord_phone_number }}</td>
                                <td>{{ $order->ord_pickup_address }}</td>
                                <td class="d-flex align-items-center gap-2">
                                  <div class="dropdown">

                                    @php
                                      $color = match($order->ord_status) {
                                        'Menunggu' => 'btn-warning',
                                        'Dalam Penjemputan' => 'btn-info',
                                        'Selesai' => 'btn-success',
                                        'Dibatalkan' => 'btn-danger',
                                        default => 'btn-secondary'
                                      };
                                    @endphp
                                    <button class="btn {{ $color }} dropdown-toggle" type="button" id="statusDropdown{{ $order->ord_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $order->ord_status }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $order->ord_id }}">
                                        <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="Menunggu">Menunggu</a></li>
                                        <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="Dalam Penjemputan">Dalam Penjemputan</a></li>
                                        <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="Selesai">Selesai</a></li>
                                        <li><a class="dropdown-item change-status" href="#" data-id="{{ $order->ord_id }}" data-status="Dibatalkan">Dibatalkan</a></li>
                                    </ul>
                                  </div>
                                </td>
                                
                                <td>
                                  <a href="/employee/pick-up/{{ $order->ord_id}}/detail" class="btn btn-primary">Detail</a>
                                  {{-- <a href="/employee/pick-up/{{ $order->ord_id}}/destroy" class="btn btn-danger" data-confirm-delete="true">Delete</a> --}}
                                  @if(in_array($order->ord_status, ['Selesai', 'Dibatalkan']))
                                    <a href="#" class="btn btn-danger delete-order" data-id="{{ $order->ord_id }}">Delete</a>
                                  @else
                                    <button class="btn btn-danger" disabled>Delete</button>
                                  @endif
                               </td>
                            </tr>
                             @endforeach
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            

                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Customer</th>
                                <th>No. Customer</th>
                                <th>Alamat Penjemputan</th>
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
            url: '/employee/pick-up/' + orderId + '/status',
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
      
      
      


@endpush