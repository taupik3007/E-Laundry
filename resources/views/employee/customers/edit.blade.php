@extends('employee.master')

@push('link')
    
@endpush

@section('title')
    E-Laundry | Tambah Pesanan
@endsection

@section('content')
   <div class="row">
    <div class="col-lg-12">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Tambah Pelanggan</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a  class="text-muted text-decoration-none" href="/employee/customers">Daftar Pelanggan</a>
                </li>
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none">Tambah Pelanggan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none">Edit Pelanggan</a>
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
            <h4 class="card-title mb-0">Tambah Pelanggan </h4>
          </div>
          <form action="{{ route('customers.update', $user->usr_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_name" class="form-control" value="{{$user->usr_name}}" id="exampleInputText1"  required 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('usr_name')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div>
                <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" value="{{$user->email}}" id="exampleInputText1"  required  
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('email')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div>
                  {{-- <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">No. Telepon</label>
                    <div class="col-sm-9">
                      <input type="telp" name="usr_telephone" class="form-control" value="{{$user->usr_telephone}}" id="exampleInputText1"  required  
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('usr_telephone')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div> --}}

                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">No. Telepon</label>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <span class="input-group-text">+62</span>
                        <input 
                            type="text"
                            id="phone"
                            name="usr_telephone"
                            value="{{$user->usr_telephone}}"
                            required
                            class="form-control"
                            placeholder="8123-4567-890"
                            maxlength="15"
                        >
                    </div>
                       @error('usr_telephone')
                      <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                  @enderror
                    </div>
                  </div>
      

                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Alamat Lengkap</label>
                    <div class="col-sm-9">
                      <input type="text" name="usr_address" class="form-control" value="{{$user->usr_address}}" id="exampleInputText1"  required  
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('usr_telephone')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div>
                  {{-- <div class="mb-4 row align-items-center">
                    <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                      <input type="password" name="password" class="form-control" id="exampleInputText1"  required  
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('password')
                      <div class="text-danger small mt-1">{{$message}}</div>
                    @enderror
                  </div> --}}
                <div class="row">
                  <div class="col-sm-3"></div>
                  <div class="col-sm-9">
                    <input type="submit" class="btn btn-primary" value="Kirim" id="">
                    <a href="/employee/customers" class="btn btn-warning">Batal</a>
                  </div>
                </div>
              </div>
          </form>
          
        </div>
      </div>
   </div>
    
@endsection



@push('script')
<script>
  document.querySelector('input[name="ord_phone_number"]').addEventListener('input', function() {
      this.value = this.value.replace(/[^0-9+]/g, ''); // hilangkan huruf & simbol lain
  });
</script>

<script>
  document.getElementById('phone').addEventListener('input', function() {
      // hanya angka
      let val = this.value.replace(/[^0-9]/g, '');

      // jika user mengawali dengan 0 → hapus otomatis
      if (val.startsWith('0')) {
          val = val.substring(1);
      }

      this.value = val;
  });
</script>
<script>
  document.getElementById('phone').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, '');
  
      if (value.length > 4 && value.length <= 8) {
          value = value.slice(0,4) + '-' + value.slice(4);
      } else if (value.length > 8) {
          value = value.slice(0,4) + '-' + value.slice(4,8) + '-' + value.slice(8,12);
      }
  
      e.target.value = value;
  });
  </script>

    
@endpush


{{-- @extends('employee.master')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('customers.index') }}" class="text-muted text-decoration-none">Daftar Pelanggan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('customers.update', $customer->usr_id) }}" method="POST">
    @csrf
    @method('PUT')


                    <div class="mb-3">
                        <label for="usr_name" class="form-label">Nama</label>
                        <input type="text" name="usr_name" value="{{ $customer->usr_name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_email" class="form-label">Email</label>
                        <input type="email" name="usr_email" value="{{ $customer->usr_email }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_nik" class="form-label">NIK</label>
                        <input type="text" name="usr_nik" value="{{ $customer->usr_nik }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_birthplace" class="form-label">Tempat Lahir</label>
                        <input type="text" name="usr_birthplace" value="{{ $customer->usr_birthplace }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="usr_birthdate" value="{{ $customer->usr_birthdate }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_gender" class="form-label">Jenis Kelamin</label>
                        <select name="usr_gender" class="form-select" required>
                            <option hidden value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki" {{ $customer->usr_gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ $customer->usr_gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="usr_religion" class="form-label">Agama</label>
                        <input type="text" name="usr_religion" value="{{ $customer->usr_religion }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="usr_telephone" class="form-label">No. Telepon</label>
                        <input type="text" name="usr_telephone" value="{{ $customer->usr_telephone }}" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection --}}
