@extends('owner.master')

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
                <h4 class="fw-semibold mb-8">Tambah Pegawai</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a  class="text-muted text-decoration-none" href="/owner/employee">Daftar Pegawai</a>
                </li>
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none">Tambah Pegawai</a>
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
            <h4 class="card-title mb-0">Tambah Pegawai </h4>
          </div>
          <form action="" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_name" class="form-control" value="{{$employee->usr_name}}" id="exampleInputText1"  required 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('usr_name')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div>
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" value="{{$employee->email}}" id="exampleInputText1"  required  
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('email')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">No. Telepon</label>
                    <div class="col-sm-9">
                      <input type="telp" name="usr_telephone" class="form-control" value="{{$employee->usr_telephone}}" id="exampleInputText1"  required  
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('usr_telephone')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div>
                <div class="row">
                  <div class="col-sm-3"></div>
                  <div class="col-sm-9">
                    <input type="submit" class="btn btn-primary" value="Kirim" id="">
                    <a href="/employee/expenditure" class="btn btn-warning">Batal</a>
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
