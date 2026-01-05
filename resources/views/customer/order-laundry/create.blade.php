@extends('customer.master')

@section('title')
E-Laundry | Tambah Pesanan
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
          <div id="order-details">
            <div class="row mb-3 order-row">
        
                <label class="col-sm-3 col-form-label">Detail Layanan</label>
        
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control service-select" name="service_id[]" class="form-control" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($services as $item)
                                    <option value="{{ $item->lds_id }}">{{ $item->lds_name }}</option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="col-md-4">
                            <select class="form-control package-select" name="package_id[]" class="form-control" required>
                                <option value="">-- Pilih Paket --</option>
                            </select>
                        </div>
        
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-add-row">+</button>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
          {{-- Qty/Berat --}}
          {{-- <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Jumlah / Berat</label>
            <div class="col-sm-9">
              <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan qty / kg" required>
            </div>
          </div> --}}

          {{-- Total --}}
          {{-- <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">Total Harga</label>
            <div class="col-sm-9">
              <input type="text" id="total_price" name="total" class="form-control" readonly>
            </div>
          </div> --}}

          <div class="mb-4 row">
            <label class="col-sm-3 col-form-label">No. Telepon</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <span class="input-group-text">+62</span>
                    <input type="tel" id="phone" name="ord_phone_number" class="form-control"
                           placeholder="81234567890"
                           pattern="^[0-9]{8,12}$"
                           maxlength="12"
                           required>
                </div>
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
              <textarea name="address" class="form-control" rows="3" 
              placeholder="Alamat Lengkap"
              required></textarea>
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
// =====================
// SHOW ALAMAT OTOMATIS
// =====================
function checkAddress() {
    let pick = $('#pickup_method').val();
    let del  = $('#delivery_method').val();

    if (pick === 'pickup' || del === 'delivery') {
        $('#address_wrapper').removeClass('d-none');
        $('#address_wrapper textarea').attr('required', true);
    } else {
        $('#address_wrapper').addClass('d-none');
        $('#address_wrapper textarea').removeAttr('required');
    }
}

$('#pickup_method, #delivery_method').on('change', checkAddress);



// =====================
// AMBIL PAKET DARI AJAX
// =====================
// event perubahan service => load paket
$(document).on("change", ".service-select", function () {
    let row = $(this).closest(".order-row");
    let serviceId = $(this).val();
    let packageSelect = row.find(".package-select");

    packageSelect.html("<option>Loading...</option>");

    $.ajax({
        url: "/customer/laundry-order/" + serviceId + "/packages",
        type: "GET",
        success: function (data) {
            packageSelect.empty().append('<option value="">-- Pilih Paket --</option>');
            $.each(data, function (i, pkg) {
                packageSelect.append(`
                    <option value="${pkg.ldp_id}" data-price="${pkg.ldp_price}">
                        ${pkg.ldp_name} – Rp ${Number(pkg.ldp_price).toLocaleString()}
                    </option>
                `);
            });
        }
    });
});


// =====================
// HITUNG TOTAL HARGA
// =====================
// $('#package_id, #quantity').on('change keyup', function () {
//     let price = $('#package_id option:selected').data('price');
//     let qty   = $('#quantity').val();

//     if (price && qty) {
//         let total = price * qty;
//         $('#total_price').val("Rp " + total.toLocaleString());
//     }
// });
document.addEventListener('click', function(e) {
        // tambah baris
        if (e.target.classList.contains('btn-add-row')) {
            let container = document.getElementById('order-details');
            let newRow = container.querySelector('.order-row').cloneNode(true);
    
            newRow.querySelectorAll('select, input').forEach(el => el.value = '');
    
            container.appendChild(newRow);
            refreshButtons();
        }
    
        // hapus baris
        if (e.target.classList.contains('btn-remove-row')) {
            e.target.closest('.order-row').remove();
            refreshButtons();
        }
    });
    
    // pertama kali jalankan
    refreshButtons();
</script>

@endpush
