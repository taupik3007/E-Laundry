@extends('employee.master')

@push('link')
    
@endpush

@section('title')
    E-Laundry Garut | Tambah Pesanan
@endsection

@section('content')
   <div class="row">
    <div class="col-lg-12">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">PEMESANAN LAUNDRY</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a  class="text-muted text-decoration-none" href="/employee/ordering">Daftar Pesanan</a>
                </li>
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none">Tambah Pesanan</a>
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
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Tambah Pesanan </h4>
          </div>
          <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama Customer</label>
                    <div class="col-sm-9">
                      <input type="text" name="" class="form-control" id="exampleInputText1" placeholder="Nama Customer" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Jenis Layanan</label>
                    <div class="col-sm-9">
                        <select class="form-select mr-sm-2"  name=""
                            oninvalid="this.setCustomValidity('Jurusan wajib diisi')"
                            onchange="this.setCustomValidity('')" required>
                            <option selected value="">Pilih...</option>
                            {{-- @foreach ($majors as $major)
                                <option value="{{ $major->mjr_id }}">{{ $major->mjr_abbr }} - {{ $major->mjr_name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    @error('cls_major_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Total</label>
                    <div class="col-sm-9">
                      <input type="text" name="" class="form-control" id="exampleInputText1" placeholder="Total Harga" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                <div class="row">
                  <div class="col-sm-3"></div>
                  <div class="col-sm-9">
                    <input type="submit" class="btn btn-primary" value="Kirim" id="">
                    <a href="/employee/ordering" class="btn btn-warning">Batal</a>
                  </div>
                </div>
              </div>
          </form>
          
        </div>
      </div>
   </div>
    
@endsection



@push('script')
    
@endpush
