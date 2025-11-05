@extends('employee.master')

@push('link')
    
@endpush

@section('title')
    E-Laundry Garut | Edit Pesanan
@endsection

@section('content')
    <div class="container-fluid">
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
      <div class="product-list">
        <div class="card">
          <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
              <form class="position-relative">
                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Product">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
              </form>
              <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter list">
                <i class="ti ti-filter"></i>
              </a>
            </div>
            <div class="table-responsive">
                <table id="file_export" class="table align-middle text-nowrap mb-0">
                    <thead>
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
                    </thead>
                    <tbody>
                        {{-- @foreach($customers as $no => $customer)--}}
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                    <i class="ti ti-dots-vertical"></i>
                                  </a>

                           </td>
                        </tr>
                        {{-- @endforeach  --}}
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
    </div>
  </div>
    
@endsection



@push('script')
    
@endpush
