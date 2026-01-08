@extends('owner.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    E-Laundry | Daftar Layanan
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Diskon</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Daftar Diskon</li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="/owner/discount/create">Tambah Diskon</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="#">Edit Diskon</a>
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

                    <h4 class="card-title mb-0">Daftar Diskon</h4>
                    <a href="/owner/discount/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Discount</a>
                </div>
                <p class="card-subtitle mb-3">
                    
                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Diskon</th>
                                <th>Total diskon</th>
                                <th>Mulai Diskon</th>
                                <th>Akhir</th>
                                <th>Status Diskon</th>
                                <th>Aksi</th>
                                
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                          @foreach ( $discount as $no=> $dsc)
                            <tr>
                                <td>{{$no+1}}</td>
                                <td>{{ $dsc->dsc_name}}</td>
                                <td>{{ $dsc->dsc_total_label }}</td>
                                <td>{{ $dsc->dsc_start }}</td>
                                <td>{{ $dsc->dsc_finish }}</td>
                                <td>{!! $dsc->dsc_status_badge !!}</td>

                             <td>
                              <div class="d-flex align-items-center gap-3">
                                <a href="/owner/discount/{{ $dsc->dsc_id}}/edit"
                                   class="text-primary"
                                   data-bs-toggle="tooltip"
                                   title="Edit">
                                  <span class="iconify" data-icon="line-md:pencil" data-width="25"></span>
                                </a>
                            
                                {{-- <a href="/owner/discount/{{ $dsc->dsc_id }}/packages"
                                   class="text-warning"
                                   data-bs-toggle="tooltip"
                                   title="Paket">
                                  <span class="iconify" data-icon="line-md:folder-plus-twotone" data-width="25"></span>
                                </a> --}}
                            
                                <a href="/owner/discount/{{ $dsc->dsc_id}}/destroy"
                                   class="text-danger"
                                   data-confirm-delete="true"
                                   data-bs-toggle="tooltip"
                                   title="Hapus">
                                  <span class="iconify" data-icon="line-md:trash" data-width="25"></span>
                                </a>
                              </div>
                            </td>
                            
                            </tr>
                            @endforeach 
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            

                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Diskon</th>
                                <th>Total diskon</th>
                                <th>Mulai Diskon</th>
                                <th>Akhir</th>
                                <th>Status Diskon</th>
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
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
@endpush
