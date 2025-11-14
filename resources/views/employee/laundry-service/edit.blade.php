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
                <h4 class="fw-semibold mb-8">Layanan</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                  <li class="breadcrumb-item" aria-current="page">Daftar Layanan</li>
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none" href="/employee/service/create">Tambah Layanan</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none">Edit Layanan</a>
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
            <h4 class="card-title mb-0">Tambah Layanan </h4>
          </div>
          <form action="{{ route('laundry-service.update', $EditService->lds_id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- Nama Layanan --}}
                <div class="mb-4 row align-items-center">
                    <label for="service_name" class="form-label col-sm-3 col-form-label">Nama Layanan</label>
                    <div class="col-sm-9">
                        <input type="text" name="lds_name" class="form-control" id="lds_name" value="{{ $EditService->lds_name }}"
                               placeholder="Nama Layanan"
                               required
                               oninvalid="this.setCustomValidity('Nama layanan wajib diisi')"
                               onchange="this.setCustomValidity('')">
                    </div>
                    @error('service_name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
        
                {{-- Upload Gambar --}}
                <div class="mb-4 row align-items-center">
                    <label for="service_image" class="form-label col-sm-3 col-form-label">Gambar Layanan</label>
                    <div class="col-sm-9">
                      <img 
                      src="{{ asset('storage/' . $EditService->lds_image) }}" 
                      id="preview" 
                      class="rounded mb-2"
                      style="max-width: 200px;">
                    </div>
                    @error('service_image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 row align-items-center">
                  <label class="form-label col-sm-3 col-form-label">Ganti Gambar</label>
                  <div class="col-sm-9">
                      <input type="file" name="lds_image" class="form-control" 
                             accept="image/*" onchange="previewImage(event)">
                      <small class="text-muted">Kosongkan jika tidak diganti</small>
                  </div>
              </div>
        
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <input type="submit" class="btn btn-primary" value="Kirim">
                        <a href="{{ route('laundry-service.index') }}" class="btn btn-warning">Batal</a>
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
  function previewImage(event) {
      const img = document.getElementById('preview');
      img.src = URL.createObjectURL(event.target.files[0]);
      img.style.display = 'block';
  }
</script>
    
@endpush
