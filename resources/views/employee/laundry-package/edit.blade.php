@extends('employee.master')

@section('title')
    E-Laundry Garut | Edit Paket - {{ $service->lds_name }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">

      {{-- Breadcrumb --}}
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">EDIT PAKET</h4>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none" href="/employee/laundry-service">Daftar Layanan</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none">Edit Paket</a>
                    </li>
                  </ol>
                </nav>
            </div>

            <div class="col-3">
              <div class="text-center mb-n5">
                <img src="{{ asset('assets/images/breadcrumb/ChatBc.png')}}" alt="img" class="img-fluid mb-n4" />
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Card Form --}}
      <div class="card">
        <div class="px-4 py-3 border-bottom">
          <h4 class="card-title mb-0">Edit Paket: {{ $package->ldp_name }}</h4>
        </div>

        <form action="{{ route('package.update', [$service->lds_id, $package->ldp_id]) }}" method="POST">
            @csrf

            <div class="card-body">

                {{-- Nama Paket --}}
                <div class="mb-4 row align-items-center">
                    <label class="form-label col-sm-3 col-form-label">Nama Paket</label>
                    <div class="col-sm-9">
                      <input type="text" name="ldp_name" class="form-control"
                             value="{{ $package->ldp_name }}"
                             required>
                    </div>
                </div>

                {{-- Harga --}}
                <div class="mb-4 row align-items-center">
                    <label class="form-label col-sm-3 col-form-label">Harga Paket</label>
                    <div class="col-sm-9">
                      <input type="text" name="ldp_price" id="harga_paket" class="form-control"
                             value="Rp {{ number_format($package->ldp_price, 0, ',', '.') }}"
                             required>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4 row align-items-center">
                    <label class="form-label col-sm-3 col-form-label">Deskripsi</label>
                    <div class="col-sm-9">
                      <textarea name="ldp_description" class="form-control" rows="3" required>{{ $package->ldp_description }}</textarea>
                    </div>
                </div>

                {{-- Durasi --}}
                <div class="mb-4 row align-items-center">
                    <label class="form-label col-sm-3 col-form-label">Durasi</label>
                    <div class="col-sm-9">
                      <input type="text" name="ldp_duration" class="form-control"
                             value="{{ $package->ldp_duration }}"
                             required>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{ route('package.index', $service->lds_id) }}" class="btn btn-warning">Batal</a>
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
  const inputRupiah = document.getElementById('harga_paket');

  inputRupiah.addEventListener('keyup', function(e) {
    this.value = formatRupiah(this.value, 'Rp ');
  });

  function formatRupiah(angka, prefix) {
      let number_string = angka.replace(/[^,\d]/g, '').toString(),
          split       = number_string.split(','),
          sisa        = split[0].length % 3,
          rupiah      = split[0].substr(0, sisa),
          ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
          let separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
  }
</script>
@endpush
