@extends('employee.master')

@push('link')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
E-Laundry | Detail Pesanan
@endsection

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Pelanggan</h4>
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/employee/customers">Daftar Pelanggan</a>
                </li>
                  <li class="breadcrumb-item" aria-current="page">Detail Pelanggan</li>
                  
                  
              </ol>

          </nav>
      </div>
        <div class="col-3">
          <div class="text-center mb-n5">
            
            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="laundry-img"
              class="img-fluid mb-n4" />
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="card overflow-hidden">
    <div class="card-body p-0">
      <img src="{{ asset('assets/images/backgrounds/profilebg.jpg')}}" 
           class="card-img-top rounded-0 object-fit-cover" 
           alt="laundry-img" height="100">
           <div class="row align-items-center">
        <div class="col-lg-4 order-lg-1 order-2">
          <div class="d-flex align-items-center justify-content-around m-4">
            <div class="text-center">
            </div>
            <div class="text-center">
            </div>
            <div class="text-center">
            </div>
          </div>
        </div>
        <div class="col-lg-4 mt-n3 order-lg-2 order-1">
          <div class="mt-n5">
            <div class="d-flex align-items-center justify-content-center mb-2">
              <div class="d-flex align-items-center justify-content-center round-110">
                <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden round-100">
                  <img src="{{ $user->usr_profile_photo
                    ? asset('storage/' . $user->usr_profile_photo)
                    : asset('assets/images/profile/user-1.jpg') }}"
                 class="w-100 h-100"
                 style="bottom: -20px; left: 20px; width: 60px; height: 60px; border: 3px solid #fff;"
                 data-bs-toggle="tooltip"
                 data-bs-placement="top"
                 alt="laundry-img">            
                  </div>
              </div>
            </div>
            <div class="text-center">
              <h5 class="mb-0">{{ $user->usr_name ?? '-' }}</h5>
              <p class="mb-0">{{ ucfirst($user->getRoleNames()->first() ?? '-') }}</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 order-last">
          <ul class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end my-3 mx-4 pe-xxl-4 gap-3">
            <li>
              </a>
            </li>
            <li>
              </a>
            </li>
            <li>
              </a>
            </li>
            <li>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-none border">
    <div class="card-body">
      <h4 class="mb-3">Detail Profile</h4>
      <p class="card-subtitle">Halo, Saya {{ $user->usr_name ?? '-' }}.
      </p>
      <div class="vstack gap-3 mt-4">
        <div class="hstack gap-6">
          <i class="ti ti-briefcase text-dark fs-6"></i>
          <h6 class=" mb-0">{{ ucfirst($user->getRoleNames()->first() ?? '-') }}</h6>
        </div>
        <div class="hstack gap-6">
          <i class="ti ti-mail text-dark fs-6"></i>
          <h6 class=" mb-0">{{ $user->email ?? '-' }}</h6>
        </div>
        <div class="hstack gap-6">
          <i class="ti ti-map-pin text-dark fs-6"></i>
          <h6 class=" mb-0">{{ $user->usr_address ?? '-' }}</h6>
        </div>
        <div class="hstack gap-6">
          <i class="ti ti-phone text-dark fs-6"></i>
          <h6 class=" mb-0">{{ $user->usr_telephone ?? '-' }}</h6>
        </div>
        <div class="hstack gap-6">
          <i class="ti ti-link text-dark fs-6"></i>
          <h6 class=" mb-0">{{ $user->created_at->format('d M Y') ?? '-' }}</h6>
        </div>
        
      </div>
    </div>
  </div>

  <!-- Card Detail -->
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
