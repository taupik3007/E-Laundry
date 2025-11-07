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
                                <th>No. Customer</th>
                                <th>Alamat Penjemputan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                
                            </tr>

                            <!-- end row -->
                        </thead>
                        <tbody>
                            {{-- @foreach($customers as $no => $customer)--}}
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="d-flex align-items-center gap-2">
                                    <!-- Dropdown status -->
                                    <div class="dropdown">
                                        <button class="btn btn-warning dropdown-toggle" type="button" id="statusDropdown{id}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Status Penjemputan
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="statusDropdown{id}">
                                            <li><a class="dropdown-item" href="#">Menunggu</a></li>
                                            <li><a class="dropdown-item" href="#">Dalam Penjemputan</a></li>
                                            <li><a class="dropdown-item" href="#">Selesai</a></li>
                                            <li><a class="dropdown-item" href="#">Dibatalkan</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <a href="/employee/ordering/{id}/detail" class="btn btn-primary">Detail</a>
                                    <a href="/employee//{id}/destroy" class="btn btn-danger" data-confirm-delete="true">Delete</a>
                               </td>
                            </tr>
                            {{-- @endforeach  --}}
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
@endpush
