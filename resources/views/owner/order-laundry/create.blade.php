@extends('owner.master')

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
                            <h4 class="fw-semibold mb-8">PEMESANAN LAUNDRY</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="/owner/order-laundry">Daftar
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
                <form action="{{ route('owner.order.store') }}" method="post">
                    @csrf

                    <div class="card-body">

                        {{-- Nomor Telepon --}}

                        <div class="mb-4 row align-items-center">
                            <label class="form-label col-sm-3 col-form-label">Nama Customer</label>

                            <div class="col-sm-9">
                                <div class="row g-2">

                                    <!-- Input Harga -->
                                    <div class="col-sm-8">

                                        <select name="ord_customer_id" id="customerSelect" required
                                            class="form-control mb-2">
                                            <option value="">-- Pilih Customer --</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->usr_id }}">
                                                    {{ $customer->usr_name }} ({{ $customer->email }})
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="text" name="ord_customer_name" id="manualInput"
                                            class="form-control mb-2 d-none" placeholder="Masukkan nama customer">

                                    </div>

                                    <div class="col-sm-4">
                                        <button type="button" class="btn btn-primary" id="manualBtn">
                                            Input Manual
                                        </button>
                                    </div>


                                    {{-- <input type="text" name="ord_customer_name" id="manualInput" class="form-control"
                                        placeholder="Masukkan nama customer" required style="display:none;" disabled> --}}
                                    @error('ord_customer_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('customer')
                                        <small class="text-danger ">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>
                            </div>
                        </div>

                        <div id="order-details">
                            <div class="row mb-3 order-row">

                                <label class="col-sm-3 col-form-label">Detail Layanan</label>

                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control service-select" name="service_id[]"
                                                class="form-control" required>
                                                <option value="">-- Pilih Layanan --</option>
                                                @foreach ($services as $item)
                                                    <option value="{{ $item->lds_id }}">{{ $item->lds_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <select class="form-control package-select" name="package_id[]" required>
                                                <option value="">-- Pilih Paket --</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control qty-input" type="number" name="quantity[]"
                                                class="form-control" min="0" step="any" placeholder="Qty / Kg"
                                                required>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-success btn-add-row">+</button>
                                        </div>

                                        <div class="col-md-4 clothes-wrapper d-none">
                                            <br>
                                            <input type="number"
                                                class="form-control clothes-input"
                                                name="odt_count[]"
                                                min="0"
                                                placeholder="Jumlah Pakaian">
                                        </div>

                                        {{-- <div class="col-md-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-success btn-add-row">+</button>
                                        </div> --}}
                                    </div>
                                </div>

                            </div>
                        </div>


                        {{-- Total --}}
                        <div class="mb-4 row">
                            <label class="col-sm-3 col-form-label">Total Harga</label>
                            <div class="col-sm-9">
                                <input type="text" id="total_price1" name="total" value="{{ old('total') }}"
                                    class="form-control" readonly>
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label class="col-sm-3 col-form-label">No. Telepon</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="tel" id="phone" name="ord_phone_number" class="form-control"
                                        placeholder="81234567890" pattern="^[0-9]{8,12}$" maxlength="12" required>
                                </div>
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
                                    <option value="self" {{ old('delivery_method') == 'self' ? 'selected' : '' }}>Ambil
                                        Sendiri</option>
                                    <option value="delivery" {{ old('delivery_method') == 'delivery' ? 'selected' : '' }}>
                                        Diantar Laundry</option>
                                </select>
                            </div>
                        </div>

                        {{-- Alamat (Auto muncul jika perlu) --}}
                        <div class="mb-4 row d-none" {{ old('delivery_method') == 'delivery' ? '' : 'd-none' }}"
                            id="address_wrapper">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea name="address" class="form-control" rows="3" placeholder="Alamat Lengkap" required>{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4 row align-items-center">
                            <label class="form-label col-sm-3 col-form-label">Catatan</label>
                            <div class="col-sm-9">
                                <textarea name="note" class="form-control" rows="3" placeholder="Deskripsi Paket" required>{{ old('note') }}</textarea>
                            </div>
                        </div>



                        {{-- Submit --}}
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button class="btn btn-primary">Kirim</button>
                                <a href="/owner/order-laundry" class="btn btn-warning">Batal</a>
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
$('#customerSelect').on('change', function () {
    let customerId = $(this).val();

    if (!customerId) {
        $('#phone').val('');
        $('textarea[name="address"]').val('');
        return;
    }

    $.ajax({
        url: '/owner/customer/' + customerId + '/detail',
        type: 'GET',
        success: function (res) {
            if (res) {
                // isi nomor (tanpa +62 karena sudah ada prefix)
                $('#phone').val(res.usr_telephone ?? '');
                // console.log(res.usr_address);

                // isi alamat
                $('textarea[name="address"]').val(res.usr_address ?? '');
            }
        }
    });
});
</script>
<script>
    document.getElementById('manualBtn').addEventListener('click', function () {
    $('#phone').val('');
    $('textarea[name="address"]').val('');
});

</script>

    <script>
        document.getElementById('manualBtn').addEventListener('click', function() {
    let manualInput = document.getElementById('manualInput');
    let customerSelect = document.getElementById('customerSelect');
    let btn = document.getElementById('manualBtn');

    if (!customerSelect.classList.contains('d-none')) {
        // ke manual
        customerSelect.classList.add('d-none');
        customerSelect.disabled = true;
        customerSelect.removeAttribute('required');

        manualInput.classList.remove('d-none');
        manualInput.disabled = false;
        manualInput.setAttribute('required', true);

        btn.textContent = "Pilih Customer";
    } else {
        // balik ke select
        manualInput.classList.add('d-none');
        manualInput.disabled = true;
        manualInput.removeAttribute('required');
        manualInput.value = "";

        customerSelect.classList.remove('d-none');
        customerSelect.disabled = false;
        customerSelect.setAttribute('required', true);

        btn.textContent = "Input Manual";
    }
});

    </script>

    <script>
        document.getElementById('quantity').addEventListener('keydown', function(e) {
            if (e.key === '-' || e.key === '+') {
                e.preventDefault();
            }
        });
    </script>

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
        // =====================
        // SHOW ALAMAT OTOMATIS
        // =====================
        function checkAddress() {
            let del = $('#delivery_method').val();

            if (del === 'delivery') {
                $('#address_wrapper').removeClass('d-none');
                $('#address_wrapper textarea').attr('required', true);
            } else {
                $('#address_wrapper').addClass('d-none');
                $('#address_wrapper textarea').removeAttr('required');
            }
        }

        // Ketika select berubah
        $('#delivery_method').on('change', checkAddress);

        // Jalankan saat pertama kali load (untuk old value setelah gagal validasi)
        $(document).ready(function() {
            checkAddress();
        });

        // Simpan old() value ke JS
        let oldPackageId = "{{ old('package_id') }}";

        $('#service_id').on('change', function() {
            var serviceId = $(this).val();
            $('#package_id').html('<option>Loading...</option>');

            if (serviceId) {
                $.ajax({
                    url: '/owner/order-laundry/' + serviceId + '/packages',
                    type: 'GET',
                    success: function(data) {
                        $('#package_id').empty().append('<option value="">-- Pilih Paket --</option>');
                        $.each(data, function(i, pkg) {
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
        $(document).ready(function() {
            if ("{{ old('service_id') }}") {
                $('#service_id').trigger('change');
            }
        });



        // =====================
        // HITUNG TOTAL HARGA
        // =====================
        //  $('#package_id, #quantity').on('change keyup', function () {
        //      let price = $('#package_id option:selected').data('price');
        //      let qty   = $('#quantity').val();

        //      if (price && qty) {
        //          let total = price * qty;
        //          $('#total_price').val("Rp " + total.toLocaleString());
        //      }
        //  });
        let oldTotal = "{{ old('total') }}";

        $('#package_id, #quantity').on('change keyup', function() {
            hitungTotal();
        });

        function hitungTotal() {
            let price = $('#package_id option:selected').data('price');
            let qty = $('#quantity').val();

            if (price && qty) {
                let total = price * qty;
                $('#total_price').val("Rp " + Number(total).toLocaleString());
            } else {
                $('#total_price').val("");
            }
        }

        $('#quantity').on('keyup change', function() {
            hitungTotal();
        });

        // AJAX load paket berdasarkan service terpilih
        $('#service_id').on('change', function() {
            var serviceId = $(this).val();
            $('#package_id').html('<option>Loading...</option>');

            $.ajax({
                url: '/owner/order-laundry/' + serviceId + '/packages',
                type: 'GET',
                success: function(data) {
                    $('#package_id').empty().append('<option value="">-- Pilih Paket --</option>');

                    $.each(data, function(i, pkg) {
                        $('#package_id').append(`
                        <option value="${pkg.ldp_id}" data-price="${pkg.ldp_price}"
                            ${pkg.ldp_id == oldPackageId ? 'selected' : ''}>
                            ${pkg.ldp_name} – Rp ${Number(pkg.ldp_price).toLocaleString()} / ${pkg.ldp_unit}
                        </option>
                    `);
                    });
                    hitungTotal();
                }
            });
        });

        // Auto trigger pada awal load untuk old() values
        $(document).ready(function() {
            if ("{{ old('service_id') }}") {
                $('#service_id').trigger('change');
            }
        });
    </script>
    <script>
     function refreshButtons() {
        let rows = document.querySelectorAll('.order-row');
    
        rows.forEach((row, index) => {
            let btn = row.querySelector('.btn-add-row, .btn-remove-row');
            if (btn) btn.remove();
    
            let col = row.querySelector('.col-md-1');
    
            if (index === 0) {
                col.innerHTML = '<button type="button" class="btn btn-success btn-add-row">+</button>';
            } else {
                col.innerHTML = '<button type="button" class="btn btn-danger btn-remove-row">-</button>';
            }
        });
    }
    
    $(document).on("click", ".btn-add-row", function () {
        let container = $("#order-details");
        let newRow = container.find(".order-row:first").clone();
    
        newRow.find("select, input").val("");
        newRow.find(".clothes-wrapper").addClass("d-none");
    
        container.append(newRow);
        refreshButtons();
    });
    
    $(document).on("click", ".btn-remove-row", function () {
        $(this).closest(".order-row").remove();
        refreshButtons();
    });
    
    $(document).ready(function () {
        refreshButtons();
    });
        // Hitung total per row
        function hitungTotalPerRow(row) {
            let price = row.find(".package-select option:selected").data("price");
            let qty = row.find(".qty-input").val();
            return (price && qty) ? price * qty : 0;
        }

        // Hitung semua baris
        function hitungGrandTotal() {
            let total = 0;

            $(".order-row").each(function() {
                total += hitungTotalPerRow($(this));
            });

            $("#total_price1").val("Rp " + Number(total).toLocaleString());
        }

        // event perubahan qty / paket
        $(document).on("change keyup", ".package-select, .qty-input", function() {
            hitungGrandTotal();
        });

        // Remove row
        $(document).on("click", ".btn-remove-row", function() {
            $(this).closest(".order-row").remove();
            hitungGrandTotal(); // <--- WAJIB BIAR TOTAL UPDATE
        });


        // event perubahan service => load paket
        $(document).on("change", ".service-select", function () {
    let row = $(this).closest(".order-row");
    let serviceId = $(this).val();
    let packageSelect = row.find(".package-select");

    packageSelect.html('<option>Loading...</option>');

    if (!serviceId) {
        packageSelect.html('<option value="">-- Pilih Paket --</option>');
        return;
    }

    $.ajax({
        url: "/owner/order-laundry/" + serviceId + "/packages",
        type: "GET",
        success: function (data) {
            packageSelect.empty().append('<option value="">-- Pilih Paket --</option>');

            $.each(data, function (i, pkg) {
                packageSelect.append(`
                    <option 
                        value="${pkg.ldp_id}"
                        data-price="${pkg.ldp_price}"
                        data-unit="${pkg.ldp_unit}">
                        ${pkg.ldp_name} – Rp ${Number(pkg.ldp_price).toLocaleString()} / ${pkg.ldp_unit}
                    </option>
                `);
            });
        }
    });
});
    </script>

<script>
    $(document).on("change", ".package-select", function () {
        let row = $(this).closest(".order-row");
        let unit = $(this).find(":selected").data("unit");
    
        if (unit === "kg") {
            row.find(".clothes-wrapper").removeClass("d-none");
            row.find(".clothes-input").attr("required", true);
        } else {
            row.find(".clothes-wrapper").addClass("d-none");
            row.find(".clothes-input").removeAttr("required").val("");
        }
    });
    </script>
<script>
    
    </script>
        
@endpush
