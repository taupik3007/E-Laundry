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
                  <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Nama Paket</label>
                  <div class="col-sm-9">
                    <input type="text"
                    name="prs_package"
                    class="form-control"
                    id="exampleInputText1"
                    placeholder="Nama Paket"
                    value="{{ old('prs_package', $EditPrice->prs_package) }}"
                    required>
                  </div>
                  @error('')
                    <div>error</div>
                  @enderror
                </div>
                <div class="mb-4 row align-items-center">
                  <label for="harga_paket" class="form-label col-sm-3 col-form-label">Harga Paket</label>
                  <div class="col-sm-9">
                    <input type="text"
             name="prs_price"
             id="harga_paket"
             class="form-control"
             value="{{ old('prs_price', 'Rp ' . number_format($EditPrice->prs_price, 0, ',', '.')) }}"
             required>
                  </div>
                  @error('harga_paket')
                    <div class="text-danger mt-1">{{ $message }}</div>
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
<script>
  const inputRupiah = document.getElementById('harga_paket');

  // Format saat mengetik
  inputRupiah.addEventListener('keyup', function(e) {
    this.value = formatRupiah(this.value, 'Rp ');
  });

  // 🔹 Format langsung saat halaman pertama dimuat
  window.addEventListener('DOMContentLoaded', function() {
    if (inputRupiah.value !== '') {
      inputRupiah.value = formatRupiah(inputRupiah.value, 'Rp ');
    }
  });

  // Fungsi format rupiah
  function formatRupiah(angka, prefix) {
    let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split         = number_string.split(','),
        sisa          = split[0].length % 3,
        rupiah        = split[0].substr(0, sisa),
        ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      let separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
  }
</script>    
@endpush
