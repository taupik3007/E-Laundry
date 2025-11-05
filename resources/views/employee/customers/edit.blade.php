@extends('employee.master')

@push('link')
    
@endpush

@section('title')
    SiTAW | Edit Jurusan
@endsection

@section('content')
   <div class="row">
    <div class="col-lg-12">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">JURUSAN</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="/administration/major">Daftar Jurusan</a>
                  </li>
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="/administration/major/create">Tambah Jurusan</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">Edit Jurusan</li>
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
            <h4 class="card-title mb-0">Edit Jurusan </h4>
          </div>
          <form action="" method="post">
            @csrf
            <div class="card-body">
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_name" value="{{$CustomerEdit->usr_name}}"  class="form-control" id="exampleInputText1" placeholder="Nama Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_email" value="{{$CustomerEdit->usr_email}}"  class="form-control" id="exampleInputText1" placeholder="Singkatan Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_birthplace" value="{{$CustomerEdit->usr_birthplace}}"  class="form-control" id="exampleInputText1" placeholder="Singkatan Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_birthdate" value="{{$CustomerEdit->usr_birthdate}}"  class="form-control" id="exampleInputText1" placeholder="Singkatan Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_religion" value="{{$CustomerEdit->usr_religion}}"  class="form-control" id="exampleInputText1" placeholder="Singkatan Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                      <select class="form-select mr-sm-2" name="usr_gender"
                                    oninvalid="this.setCustomValidity('Tingkatan wajib diisi')"
                                    oninput="this.setCustomValidity('')" required>
                                    <option hidden value="">Pilih Tingkatan</option>
                                    <option value="Laki-Laki" {{ $CustomerEdit->usr_gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ $CustomerEdit->usr_gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                    </div>
                    @error('')
                      <div>error</div>
                    @enderror
                  </div>
                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">No. Telephone</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_telephone" value="{{$CustomerEdit->usr_telephone}}"  class="form-control" id="exampleInputText1" placeholder="Singkatan Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
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
