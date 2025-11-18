@extends('employee.master')

@section('title')
E-Laundry Garut | Tambah Pesanan
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">

    <div class="card">
      <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Tambah Pesanan</h4>
      </div>

      <form action="{{ route('laundry-order.store') }}" method="post">
        @csrf

        <div class="card-body">

          {{-- Nomor Telepon --}}
          {{-- Layanan --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Layanan</label>
            <div class="col-sm-9">
            <select id="service_id" name="service_id" class="form-control" required>
              <option value="">-- Pilih Layanan --</option>
              @foreach($services as $service)
                <option value="{{ $service->lds_id }}">{{ $service->lds_name }}</option>
              @endforeach
            </select>
          </div>
          </div>

          {{-- Paket --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Paket Layanan</label>
            <div class="col-sm-9">
            <select id="package_id" name="package_id" class="form-control" required>
              <option value="">-- Pilih Paket --</option>
            </select>
          </div>
          </div>

          {{-- Qty/Berat --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Jumlah / Berat</label>
            <div class="col-sm-9">
              <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan qty / kg" required>
            </div>
          </div>

          {{-- Total --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Total Harga</label>
            <div class="col-sm-9">
              <input type="text" id="total_price" name="total" class="form-control" readonly>
            </div>
          </div>

          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">No. Telepon</label>
            <div class="col-sm-9">
              <input type="number" name="ord_phone_number" class="form-control" placeholder="08xxxx" required>
            </div>
          </div>

          {{-- Metode Penjemputan --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Metode Penjemputan</label>
            <div class="col-sm-9">
              <select name="pickup_method" id="pickup_method" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="self">Diantar Sendiri</option>
                <option value="pickup">Dijemput Laundry</option>
              </select>
            </div>
          </div>

          {{-- Metode Pengantaran --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Metode Pengantaran</label>
            <div class="col-sm-9">
              <select name="delivery_method" id="delivery_method" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="self">Ambil Sendiri</option>
                <option value="delivery">Diantar Laundry</option>
              </select>
            </div>
          </div>

          {{-- Alamat (Auto muncul jika perlu) --}}
          <div class="mb-4 row d-none" id="address_wrapper">
            <label class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
              <input type="text" name="address" class="form-control" placeholder="Alamat Lengkap">
            </div>
          </div>

          <div class="mb-4 row align-items-center">
            <label class="form-label col-sm-3 col-form-label">Catatan</label>
            <div class="col-sm-9">
              <textarea name="note" class="form-control" rows="3" 
                        placeholder="Deskripsi Paket"
                        required></textarea>
            </div>
        </div>

  

          {{-- Submit --}}
          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <button class="btn btn-primary">Kirim</button>
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
// =====================
// SHOW ALAMAT OTOMATIS
// =====================
function checkAddress() {
    let pick = $('#pickup_method').val();
    let del  = $('#delivery_method').val();

    if (pick === 'pickup' || del === 'delivery') {
        $('#address_wrapper').removeClass('d-none');
    } else {
        $('#address_wrapper').addClass('d-none');
    }
}

$('#pickup_method, #delivery_method').on('change', checkAddress);



// =====================
// AMBIL PAKET DARI AJAX
// =====================
$('#service_id').on('change', function() {

    var serviceId = $(this).val();
    $('#package_id').html('<option>Loading...</option>');

    if (serviceId) {
        $.ajax({
            url: '/customer/laundry-order/' + serviceId + '/packages',
            type: 'GET',
            success: function(data) {
                $('#package_id').empty().append('<option value="">-- Pilih Paket --</option>');
                $.each(data, function(i, pkg) {
                    $('#package_id').append(`
                        <option value="${pkg.ldp_id}" data-price="${pkg.ldp_price}">
                          ${pkg.ldp_name} – Rp ${Number(pkg.ldp_price).toLocaleString()} / ${pkg.ldp_unit}
                        </option>
                    `);
                });
            }
        });
    }
});


// =====================
// HITUNG TOTAL HARGA
// =====================
$('#package_id, #quantity').on('change keyup', function () {
    let price = $('#package_id option:selected').data('price');
    let qty   = $('#quantity').val();

    if (price && qty) {
        let total = price * qty;
        $('#total_price').val("Rp " + total.toLocaleString());
    }
});
</script>

@endpush
