@extends('employee.master')

@section('title')
E-Laundry Garut | Edit Pesanan
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">

    <div class="card">
      <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Edit Pesanan</h4>
      </div>

      <form action="" method="post">
        @csrf

        <div class="card-body">

          {{-- Layanan --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Layanan</label>
            <div class="col-sm-9">
              <select id="service_id" name="service_id" class="form-control" required>
                <option value="">-- Pilih Layanan --</option>
                @foreach($services as $service)
                    <option value="{{ $service->lds_id }}"
                      {{ $order->ord_service_id == $service->lds_id ? 'selected' : '' }}>
                      {{ $service->lds_name }}
                    </option>
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
                @foreach($packages as $pkg)
                  <option value="{{ $pkg->ldp_id }}"
                    data-price="{{ $pkg->ldp_price }}"
                    {{ $order->ord_packages_id == $pkg->ldp_id ? 'selected' : '' }}>
                    {{ $pkg->ldp_name }} – Rp {{ number_format($pkg->ldp_price) }} / {{ $pkg->ldp_unit }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- Qty/Berat --}}
          {{-- <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Jumlah / Berat</label>
            <div class="col-sm-9">
              <input type="number" id="quantity" name="quantity" class="form-control"
                     value="{{ $order->ord_quantity }}" required>
            </div>
          </div> --}}

          {{-- Total --}}
          {{-- <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Total Harga</label>
            <div class="col-sm-9">
              <input type="text" id="total_price" class="form-control"
                     value="Rp {{ number_format($order->ord_total,0,',','.') }}" readonly>
            </div>
          </div> --}}

          {{-- No HP --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">No. Telepon</label>
            <div class="col-sm-9">
              <input type="number" name="ord_phone_number" class="form-control"
                     value="{{ $order->ord_phone_number }}" required>
            </div>
          </div>

          {{-- Metode Penjemputan --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Metode Penjemputan</label>
            <div class="col-sm-9">
              <select name="pickup_method" id="pickup_method" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="self"   {{ $order->ord_pickup_method == 'self' ? 'selected' : '' }}>Diantar Sendiri</option>
                <option value="pickup" {{ $order->ord_pickup_method == 'pickup' ? 'selected' : '' }}>Dijemput Laundry</option>
              </select>
            </div>
          </div>

          {{-- Metode Pengantaran --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Metode Pengantaran</label>
            <div class="col-sm-9">
              <select name="delivery_method" id="delivery_method" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="self"     {{ $order->ord_delivery_method == 'self' ? 'selected' : '' }}>Ambil Sendiri</option>
                <option value="delivery" {{ $order->ord_delivery_method == 'delivery' ? 'selected' : '' }}>Diantar Laundry</option>
              </select>
            </div>
          </div>

          {{-- Alamat --}}
          <div class="mb-4 row {{ ($order->ord_pickup_method=='pickup' || $order->ord_delivery_method=='delivery') ? '' : 'd-none' }}" id="address_wrapper">
            <label class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
              <textarea name="address" class="form-control" rows="3" placeholder="Catatan" required>{{ $order->ord_address }}</textarea>
            </div>
          </div>

          <div class="mb-4 row align-items-center">
            <label class="form-label col-sm-3 col-form-label">Catatan</label>
            <div class="col-sm-9">
              <textarea name="note" class="form-control" rows="3" placeholder="Catatan" required>{{ $order->ord_note }}</textarea>
            </div>
        </div>

          {{-- Submit --}}
          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <button class="btn btn-primary">Simpan Perubahan</button>
              <a href="{{ route('laundry-order.index') }}" class="btn btn-warning">Batal</a>
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

// =========================
// TAMPIL/SEMBUNYIKAN ALAMAT
// =========================
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


// =========================
// LOAD PAKET BY SERVICE
// =========================
$('#service_id').on('change', function () {
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


// =========================
// HITUNG TOTAL OTOMATIS
// =========================
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
