@extends('owner.master')

@push('link')
    
@endpush

@section('title')
    E-Laundry | Tambah Layanan 
@endsection

@section('content')
   <div class="row">
    <div class="col-lg-12">
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
                <img src="{{ asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="card">
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Tambah Diskon </h4>
          </div>
          <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- Nama Layanan --}}
                <div class="mb-4 row align-items-center">
                    <label for="dsc_name" class="form-label col-sm-3 col-form-label">Nama Diskon</label>
                    <div class="col-sm-9">
                        <input type="text" name="dsc_name" class="form-control" id="dsc_name"
                               placeholder="Nama Diskon"
                               required
                               oninvalid="this.setCustomValidity('Nama layanan wajib diisi')"
                               onchange="this.setCustomValidity('')">
                    </div>
                    @error('dsc_name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
        
                {{-- Upload Gambar --}}
                
                <div class="mb-4 row align-items-center">
                    <label  class="form-label col-sm-3 col-form-label">Jenis Diskon</label>
                    <div class="col-sm-9">
                    <select name="dsc_type" id="dsc_type" class="form-select">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="percent">Persen (%)</option>
                        <option value="nominal">Rupiah (Rp)</option>
                    </select>
                    </div>
                </div>
                
                <div class="mb-4 row align-items-center">
                    <label class="form-label col-sm-3 col-form-label" id="label-total">Total Diskon</label>
                    <div class="col-sm-9">
                    {{-- INPUT TAMPILAN --}}
                    <input type="text"
                           id="dsc_total_display"
                           class="form-control"
                           placeholder="Masukkan total diskon"
                           disabled>
                
                    {{-- INPUT ASLI (DIKIRIM KE SERVER) --}}
                    <input type="hidden" name="dsc_total" id="dsc_total">
                
                    <small class="text-muted" id="diskon-help"></small>
                    </div>
                </div>
                    
                
                <div class="mb-4 row align-items-center">
                    <label  class="form-label col-sm-3 col-form-label">Tanggal Mulai</label>
                    <div class="col-sm-9">
                    <input type="datetime-local" name="dsc_start"
                           class="form-control" required>
                </div>
                </div>
                
                <div class="mb-4 row align-items-center">
                    <label  class="form-label col-sm-3 col-form-label">Tanggal Selesai</label>
                    <div class="col-sm-9">
                    <input type="datetime-local" name="dsc_finish"
                           class="form-control" required>
                    </div>
                </div>
                
                
        
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <input type="submit" class="btn btn-primary" value="Kirim">
                        <a href="{{ route('owner.disc.index') }}" class="btn btn-warning">Batal</a>
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
    const typeSelect = document.getElementById('dsc_type');
    const displayInput = document.getElementById('dsc_total_display');
    const realInput = document.getElementById('dsc_total');
    const label = document.getElementById('label-total');
    const help = document.getElementById('diskon-help');
    
    typeSelect.addEventListener('change', function () {
        displayInput.disabled = false;
        displayInput.value = '';
        realInput.value = '';
    
        if (this.value === 'percent') {
            label.innerText = 'Total Diskon (%)';
            displayInput.placeholder = 'Contoh: 10%';
            help.innerText = 'Maksimal 100%';
        } else if (this.value === 'nominal') {
            label.innerText = 'Total Diskon (Rp)';
            displayInput.placeholder = 'Contoh: Rp 10.000';
            help.innerText = 'Nominal rupiah';
        } else {
            displayInput.disabled = true;
            help.innerText = '';
        }
    });
    
    displayInput.addEventListener('input', function () {
        let type = typeSelect.value;
        let value = this.value.replace(/\D/g, '');
    
        if (!value) {
            realInput.value = '';
            this.value = '';
            return;
        }
    
        if (type === 'percent') {
            let percent = Math.min(100, parseInt(value));
            realInput.value = percent;
            this.value = percent + '%';
        }
    
        if (type === 'nominal') {
            realInput.value = value;
            this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        }
    });
    </script>
        
    
@endpush
