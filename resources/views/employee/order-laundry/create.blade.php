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
                                        <a class="text-muted text-decoration-none" href="/employee/ordering">Daftar
                                            Pesanan</a>
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
                                <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img"
                                    class="img-fluid mb-n4" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="px-4 py-3 border-bottom">
                    <h4 class="card-title mb-0">Tambah Pesanan </h4>
                </div>
                <form action="{{ route('order.store') }}" method="post">
                    @csrf
            
                    <div class="card-body">
            
                      {{-- Nomor Telepon --}}

                      <div class="mb-4 row align-items-center">
                        <label class="form-label col-sm-3 col-form-label">Nama Customer</label>
                    
                        <div class="col-sm-9">
                            <div class="row g-2">
                    
                                <!-- Input Harga -->
                                <div class="col-sm-8">
                                    <select name="ord_customer_id" id="customerSelect" class="form-control mb-2">
                                        <option value="">-- Pilih Customer --</option>
                                        @foreach ($customers as $customer)
                                        <option value="{{ $customer->usr_id }}">
                                            {{ $customer->usr_name }} ({{ $customer->email }})
                                        </option>                                        
                                        @endforeach
                                </select>
@error('ord_customer_id')
   <small class="text-danger">{{ $message }}</small>
@enderror
                                </div>
                    
                                <!-- Input Unit -->
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-sm btn-secondary mb-2" id="manualBtn">
                                        Input Manual
                                    </button>
                                </div>

                                <input type="text" name="ord_customer_name" id="manualInput" class="form-control"
                            placeholder="Masukkan nama customer"
                            style="display:none;" disabled>
                            @error('ord_customer_name')
   <small class="text-danger">{{ $message }}</small>
@enderror
                    
                            </div>
                        </div>
                    </div>

                      {{-- Layanan --}}
                      <div class="mb-4 row">
                        <label class="col-sm-3 col-form-label">Layanan</label>
                        <div class="col-sm-9">
                            <select id="service_id" name="service_id" class="form-control" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($services as $item)
                                    <option value="{{ $item->lds_id }}" {{ old('service_id') == $item->lds_id ? 'selected' : '' }}>
                                        {{ $item->lds_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
            
                      {{-- Paket --}}
                      <div class="mb-4 row">
                        <label class="col-sm-3 col-form-label">Paket Layanan</label>
                        <div class="col-sm-9">
                            <select id="package_id" name="package_id" class="form-control" required>
                                <option value="">-- Pilih Paket --</option>
                            </select>
                            @error('package_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

            
                      {{-- Qty/Berat --}}
                      <div class="mb-4 row">
                        <label class="col-sm-3 col-form-label">Jumlah / Berat</label>
                        <div class="col-sm-9">
                          <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity') }}" placeholder="Masukkan qty / kg" required>
                        </div>
                      </div>
            
                      {{-- Total --}}
                      <div class="mb-4 row">
                        <label class="col-sm-3 col-form-label">Total Harga</label>
                        <div class="col-sm-9">
                          <input type="text" id="total_price" name="total" value="{{ old('total_price') }}" class="form-control" readonly>
                        </div>
                      </div>
            
                      <div class="mb-4 row">
                        <label class="col-sm-3 col-form-label">No. Telepon</label>
                        <div class="col-sm-9">
                          <input type="number" name="ord_phone_number" class="form-control" value="{{ old('ord_phone_number') }}" placeholder="08xxxx" required>
                        </div>
                      </div>
            
                      {{-- Metode Penjemputan --}}
                      {{-- <div class="mb-4 row">
                        <label class="col-sm-3 col-form-label">Metode Penjemputan</label>
                        <div class="col-sm-9">
                          <select name="pickup_method" id="pickup_method" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="self">Diantar Sendiri</option>
                            <option value="pickup">Dijemput Laundry</option>
                          </select>
                        </div>
                      </div> --}}
            
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
    document.getElementById('manualBtn').addEventListener('click', function () {
    let manualInput = document.getElementById('manualInput');
    let customerSelect = document.getElementById('customerSelect');

    if (manualInput.style.display === 'none') {
        manualInput.style.display = 'block';
        manualInput.disabled = false;
        customerSelect.value = "";
    } else {
        manualInput.style.display = 'none';
        manualInput.disabled = true;
    }
});

    </script>
    
<script>
    // =====================
    // SHOW ALAMAT OTOMATIS
    // =====================
    function checkAddress() {
        let del  = $('#delivery_method').val();
    
        if (del === 'delivery') {
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
    // $('#service_id').on('change', function() {
    
    //     var serviceId = $(this).val();
    //     $('#package_id').html('<option>Loading...</option>');
    
    //     if (serviceId) {
    //         $.ajax({
    //             url: '/employee/ordering/' + serviceId + '/packages',
    //             type: 'GET',
    //             success: function(data) {
    //                 $('#package_id').empty().append('<option value="">-- Pilih Paket --</option>');
    //                 $.each(data, function(i, pkg) {
    //                     $('#package_id').append(`
    //                         <option value="${pkg.ldp_id}" data-price="${pkg.ldp_price}"  ${pkg.ldp_id == "{{ old('package_id') }}" ? 'selected' : ''}>
    //                           ${pkg.ldp_name} – Rp ${Number(pkg.ldp_price).toLocaleString()} / ${pkg.ldp_unit}
    //                         </option>
    //                     `);
    //                 });
    //             }
    //         });
    //     }
    // });
    
      // Simpan old() value ke JS
      let oldPackageId = "{{ old('package_id') }}";

$('#service_id').on('change', function () {
    var serviceId = $(this).val();
    $('#package_id').html('<option>Loading...</option>');

    if (serviceId) {
        $.ajax({
            url: '/employee/ordering/' + serviceId + '/packages',
            type: 'GET',
            success: function (data) {
                $('#package_id').empty().append('<option value="">-- Pilih Paket --</option>');
                $.each(data, function (i, pkg) {
                    $('#package_id').append(`
                        <option value="${pkg.ldp_id}" data-price="${pkg.ldp_price}"
                            ${pkg.ldp_id == oldPackageId ? 'selected' : ''}>
                            ${pkg.ldp_name} – Rp ${Number(pkg.ldp_price).toLocaleString()} / ${pkg.ldp_unit}
                        </option>
                    `);
                });
            }
        });
    }
});

// Trigger otomatis jika old service ada (validasi gagal)
$(document).ready(function () {
    if ("{{ old('service_id') }}") {
        $('#service_id').trigger('change');
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
