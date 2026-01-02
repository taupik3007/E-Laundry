@extends('customer.master')

@section('title')
E-Laundry | Edit Pesanan
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">

    <div class="card">
      <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Edit Pesanan</h4>
      </div>

      <form action="{{ route('laundry-order.update', $order->ord_id) }}" method="post">
        @csrf

        <div class="card-body">

@foreach($order->details as $detail)

<div class="order-row">

    {{-- Layanan --}}
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Layanan</label>
        <div class="col-sm-9">
            <select name="service_id[]"
                    class="form-control service-select"
                    required>
                @foreach($services as $service)
                    <option value="{{ $service->lds_id }}"
                        {{ $detail->odt_service_id == $service->lds_id ? 'selected' : '' }}>
                        {{ $service->lds_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Paket --}}
    <div class="mb-4 row">
        <label class="col-sm-3 col-form-label">Paket</label>
        <div class="col-sm-9">
            <select name="package_id[]"
                    class="form-control package-select"
                    required>
                @foreach(
                    \App\Models\LaundryPackage::where('ldp_service_id', $detail->odt_service_id)->get()
                    as $pkg
                )
                    <option value="{{ $pkg->ldp_id }}"
                        {{ $detail->odt_package_id == $pkg->ldp_id ? 'selected' : '' }}>
                        {{ $pkg->ldp_name }} – Rp {{ number_format($pkg->ldp_price) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

</div>
@endforeach

          {{-- No Telepon --}}
         
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">No. Telepon</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <span class="input-group-text">+62</span>
                    <input type="tel" id="phone" name="ord_phone_number" value="{{ $order->ord_phone_number }}" class="form-control"
                           placeholder="81234567890"
                           pattern="^[0-9]{8,12}$"
                           maxlength="12"
                           required>
                </div>
            </div>
        </div>

          {{-- Penjemputan --}}
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

          {{-- Pengantaran --}}
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
              <textarea name="address" class="form-control" rows="3"
                        placeholder="Alamat Lengkap">{{ $order->ord_address }}</textarea>
            </div>
          </div>

          {{-- Catatan --}}
          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Catatan</label>
            <div class="col-sm-9">
              <textarea name="note" class="form-control" rows="3"
                        placeholder="Catatan">{{ $order->ord_note }}</textarea>
            </div>
          </div>

          {{-- Submit --}}
          <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <button class="btn btn-primary" type="submit">Kirim</button>
              <a href="/customer/laundry-order" class="btn btn-warning">Batal</a>
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
$(document).ready(function () {

    $(document).on('change', '.service-select', function () {

        let serviceId = $(this).val();

        // cari package select dalam 1 order-row
        let packageSelect = $(this)
            .closest('.order-row')
            .find('.package-select');

        packageSelect.html('<option>Loading...</option>');

        $.ajax({
            url: `/customer/laundry-order/${serviceId}/packages`,
            type: 'GET',
            success: function (data) {

                packageSelect.empty()
                    .append('<option value="">-- Pilih Paket --</option>');

                data.forEach(pkg => {
                    packageSelect.append(`
                        <option value="${pkg.ldp_id}">
                            ${pkg.ldp_name} – Rp ${Number(pkg.ldp_price).toLocaleString()}
                        </option>
                    `);
                });
            },
            error: function () {
                packageSelect.html('<option>Gagal memuat paket</option>');
            }
        });
    });

});
</script>
@endpush