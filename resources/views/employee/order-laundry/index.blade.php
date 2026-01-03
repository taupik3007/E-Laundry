@extends('employee.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
    {{-- <style>
        .dataTables_wrapper {
            overflow-x: auto;
        }

        table.dataTable {
            white-space: nowrap;
        }
    </style> --}}
@endpush

@section('title')
    E-Laundry | Daftar Pesanan
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">PEMESANAN LAUNDRY</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Daftar Pesanan</li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/employee/ordering/create">Tambah
                                        Pesanan</a>
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
                            <img src="{{ asset('assets/images/breadcrumb/trolli.png') }}" alt="modernize-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">

                    <h4 class="card-title mb-0">Daftar Pesanan</h4>
                    <a href="/employee/ordering/create" class="btn btn-primary position-absolute top-0 end-0">Tambah
                        Pesanan</a>

                </div>
                <p class="card-subtitle mb-3">

                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>

                            <tr>
                                <th width="10%">No</th>
                                <th>Invoice</th>
                                <th width="20%">Nama Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>

                            </tr>

                            <!-- end row -->
                        </thead>
                        <tbody>
                            @foreach ($orderlist as $no => $order)
                                <tr id="order-row-{{ $order->ord_id }}">

                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $order->ord_invoice ?? '-' }}</td>
                                    <td>{{ $order->ord_customer_name }}</td>

                                    <td>
                                        Rp
                                        {{ number_format($order->ord_total ?? $order->details->sum('odt_total'), 0, ',', '.') }}

                                    </td>
                                    <td class="d-flex align-items-center gap-2">
                                        <div class="dropdown">

                                            @php
                                                // Warna tombol status
                                                $color = match (strtolower($order->ord_status)) {
                                                    'menunggu' => 'btn-warning',
                                                    'menunggu penjemputan' => 'btn-warning',
                                                    'dalam penjemputan' => 'btn-info',
                                                    'menunggu penyerahan' => 'btn-primary',
                                                    'proses' => 'btn-secondary',
                                                    'menunggu pengantaran' => 'btn-primary',
                                                    'dalam pengantaran' => 'btn-info',
                                                    'menunggu pengambilan' => 'btn-primary',
                                                    'selesai' => 'btn-success',
                                                    'dibatalkan' => 'btn-danger',
                                                    default => 'btn-secondary',
                                                };

                                                // Dropdown dinamis
                                                $options = [];

                                                switch ($order->ord_status) {
                                                    case 'menunggu penjemputan':
                                                        $options = ['dalam Penjemputan', 'dibatalkan'];
                                                        break;

                                                    case 'dalam penjemputan':
                                                    case 'menunggu penyerahan':
                                                        break;

                                                    case 'proses':
                                                        $options =
                                                            $order->ord_delivery_method == 'delivery'
                                                                ? ['menunggu pengantaran']
                                                                : ['menunggu pengambilan'];
                                                        break;

                                                    case 'menunggu pengantaran':
                                                        $options = ['dalam pengantaran'];
                                                        break;

                                                    case 'dalam pengantaran':
                                                    case 'menunggu pengambilan':
                                                    $options = [];
                                                            if (
                                                                $order->payment &&
                                                                (
                                                                    $order->payment->pym_payment_status == 1
                                                                    || $order->payment->pym_is_debt == 1
                                                                )
                                                            ) {
                                                                $options[] = 'selesai';
                                                            }
                                                            break;
                                                }
                                            @endphp

                                            <button class="btn {{ $color }} dropdown-toggle" type="button"
                                                id="statusDropdown{{ $order->ord_id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                {{ $order->ord_status }}
                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $order->ord_id }}">
                                                @foreach ($options as $opt)
                                                    <li>
                                                        <a class="dropdown-item change-status" href="#"
                                                            data-id="{{ $order->ord_id }}"
                                                            data-status="{{ $opt }}">
                                                            {{ $opt }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>

                                    </td>
                                    <td id="button-{{ $order->ord_id }}">
                                       {{-- 1. SUDAH LUNAS --}}
                                        @if ($order->payment && $order->payment->pym_payment_status == 1)

                                        <span class="btn btn-success"
                                            data-bs-toggle="tooltip"
                                            title="Pembayaran sudah lunas">
                                            <span class="iconify"
                                                data-icon="ic:baseline-price-check"
                                                data-width="20"></span>
                                        </span>
                                        <a href="/employee/ordering/{{ $order->ord_id }}/detail"
                                            class="btn btn-info"
                                            data-bs-toggle="tooltip"
                                            title="Detail Pesanan">
                                        
                                            <span class="iconify"
                                                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>
                                        
                                        
                                        <a href="/employee/ordering/{{ $order->ord_id }}/destroy"
                                            class="btn btn-danger"
                                            data-confirm-delete="true"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Pesanan">
                                            <span class="iconify"
                                                data-icon="line-md:file-remove-filled"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>

                                        {{-- 2. DP / PIUTANG --}}
                                        @elseif (
                                        $order->payment &&
                                        $order->payment->pym_payment_status == 0 &&
                                        $order->payment->pym_is_debt == 1
                                        )

                                        <a href="{{ route('debt.byOrder', $order->ord_id) }}"
                                        class="btn btn-danger"
                                        data-bs-toggle="tooltip"
                                        title="Bayar sebagian">
                                            <span class="iconify"
                                                data-icon="mdi:cash-clock"
                                                data-width="20"></span>
                                        </a>
                                        <a href="/employee/ordering/{{ $order->ord_id }}/detail"
                                            class="btn btn-info"
                                            data-bs-toggle="tooltip"
                                            title="Detail Pesanan">
                                        
                                            <span class="iconify"
                                                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>
                                        
                                        
                                        <a href="/employee/ordering/{{ $order->ord_id }}/destroy"
                                            class="btn btn-danger"
                                            data-confirm-delete="true"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Pesanan">
                                            <span class="iconify"
                                                data-icon="line-md:file-remove-filled"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>

                                        {{-- 3. PROSES + BELUM BAYAR (TIMBANG + BAYAR) --}}
                                        @elseif (!$order->payment && $order->ord_status === 'proses')

                                        <button class="btn btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalTimbang{{ $order->ord_id }}"
                                                title="Timbang">
                                            <span class="iconify"
                                                data-icon="ic:baseline-balance"
                                                data-width="18"></span>
                                        </button>

                                        <button class="btn btn-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalBayar{{ $order->ord_id }}"
                                                title="Pembayaran">
                                            <span class="iconify"
                                                data-icon="tabler:user-dollar"
                                                data-width="20"></span>
                                        </button>
                                        <a href="/employee/ordering/{{ $order->ord_id }}/detail"
                                            class="btn btn-info"
                                            data-bs-toggle="tooltip"
                                            title="Detail Pesanan">
                                        
                                            <span class="iconify"
                                                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>
                                        
                                        
                                        <a href="/employee/ordering/{{ $order->ord_id }}/destroy"
                                            class="btn btn-danger"
                                            data-confirm-delete="true"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Pesanan">
                                            <span class="iconify"
                                                data-icon="line-md:file-remove-filled"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>

                                        {{-- 4. STATUS TIMBANG (HANYA TIMBANG) --}}
                                        @elseif (
                                        !$order->payment &&
                                        in_array($order->ord_status, [
                                            'menunggu penjemputan',
                                            'dalam penjemputan',
                                            'menunggu penyerahan'
                                        ])
                                        )

                                        <button class="btn btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalTimbang{{ $order->ord_id }}"
                                                title="Timbang">
                                            <span class="iconify"
                                                data-icon="ic:baseline-balance"
                                                data-width="18"></span>
                                        </button>
                                        <a href="/employee/ordering/{{ $order->ord_id }}/detail"
                                            class="btn btn-info"
                                            data-bs-toggle="tooltip"
                                            title="Detail Pesanan">
                                        
                                            <span class="iconify"
                                                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>
                                        
                                        
                                        <a href="/employee/ordering/{{ $order->ord_id }}/destroy"
                                            class="btn btn-danger"
                                            data-confirm-delete="true"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Pesanan">
                                            <span class="iconify"
                                                data-icon="line-md:file-remove-filled"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>

                                        {{-- 5. STATUS LANJUT (BAYAR SAJA) --}}
                                        @elseif (
                                        !$order->payment &&
                                        in_array($order->ord_status, [
                                            'menunggu pengantaran',
                                            'dalam pengantaran',
                                            'menunggu pengambilan'
                                        ])
                                        )

                                        <button class="btn btn-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalBayar{{ $order->ord_id }}"
                                                title="Pembayaran">
                                            <span class="iconify"
                                                data-icon="tabler:user-dollar"
                                                data-width="20"></span>
                                        </button>
                                        <a href="/employee/ordering/{{ $order->ord_id }}/detail"
                                            class="btn btn-info"
                                            data-bs-toggle="tooltip"
                                            title="Detail Pesanan">
                                        
                                            <span class="iconify"
                                                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>
                                        
                                        
                                        <a href="/employee/ordering/{{ $order->ord_id }}/destroy"
                                            class="btn btn-danger"
                                            data-confirm-delete="true"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Pesanan">
                                            <span class="iconify"
                                                data-icon="line-md:file-remove-filled"
                                                data-width="22"
                                                data-height="22"></span>
                                        </a>

                                        @endif
                                    </td>
                                </tr>
                                <!-- Modal Timbangan -->
                                <div class="modal fade" id="modalTimbang{{ $order->ord_id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <form method="POST"
                                                action="{{ route('order.updateWeight', $order->ord_id) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Input Timbangan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">

                                                    @foreach ($order->details as $detail)
                                                        <div class="mb-3 p-2 border rounded">
                                                            <p class="fw-bold">{{ $detail->service->lds_name }}
                                                                {{ $detail->package->ldp_name }}</p>

                                                            <label>Jumlah ({{ $detail->package->ldp_unit }})</label>
                                                            <input type="number" step="0.1"
                                                                id="qty{{ $detail->odt_id }}"
                                                                name="details[{{ $detail->odt_id }}][odt_quantity]"
                                                                class="form-control mb-2 qty-input-{{ $order->ord_id }}"
                                                                value="{{ $detail->odt_quantity }}"
                                                                data-original="{{ $detail->odt_quantity }}"
                                                                data-id="{{ $detail->odt_id }}"
                                                                data-price="{{ $detail->odt_price }}">

                                                            <label>Harga per {{ $detail->package->ldp_unit }}</label>
                                                            <input type="text" class="form-control mb-2"
                                                                value="Rp {{ number_format($detail->odt_price, 0, ',', '.') }}"
                                                                readonly>
                                                        </div>
                                                    @endforeach

                                                    <label>Total Harga</label>
                                                    <input type="text" id="grandTotal{{ $order->ord_id }}"
                                                        class="form-control" readonly>

                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-primary">Simpan</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>


                                <!-- MODAL PEMBAYARAN -->
                                <!-- MODAL PEMBAYARAN -->
                                <div class="modal fade" id="modalBayar{{ $order->ord_id }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('order.payment', $order->ord_id) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Pembayaran Pesanan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <label>Total Harga</label>
                                                    <input type="text" class="form-control mb-2"
                                                        value="Rp {{ number_format($order->ord_total ?? 0, 0, ',', '.') }}"
                                                        readonly>

                                                    <!-- METODE -->
                                                    <label>Metode Pembayaran</label>
                                                    <select name="payment_method" class="form-control mb-2"
                                                        onchange="toggleMetode({{ $order->ord_id }}, this)" required>
                                                        <option value="">-- Pilih Metode --</option>
                                                        <option value="cash">Cash</option>
                                                        <option value="transfer">Transfer</option>
                                                    </select>

                                                    <!-- SECTION CASH -->
                                                    <div id="cashSection{{ $order->ord_id }}" style="display:none;">
                                                        <label>Jumlah Bayar</label>
                                                        <input type="text" class="form-control"
                                                            id="jumlahBayar{{ $order->ord_id }}" name="payment_amount"
                                                            oninput="formatBayar{{ $order->ord_id }}(this)">

                                                        <label>Kembalian</label>
                                                        <input type="text" class="form-control"
                                                            id="kembalian{{ $order->ord_id }}" readonly>

                                                        <button class="btn btn-success mt-3" type="submit">
                                                            Konfirmasi Pembayaran Cash
                                                        </button>
                                                    </div>

                                                    {{-- transfer section --}}
                                                    <div id="transferSection{{ $order->ord_id }}" style="display:none;">
                                                        <button type="button" class="btn btn-primary w-100"
                                                            onclick="bayarMidtrans({{ $order->ord_id }})">
                                                            Bayar via Midtrans
                                                        </button>
                                                    </div>

                                                    <!-- SECTION QRIS -->
                                                    {{-- <div id="qrisSection{{ $order->ord_id }}" style="display:none;"
                                                        class="text-center">
                                                        <p class="mt-2">Scan QRIS untuk membayar:</p>
                                                        <img src="{{ asset('assets/images/qris/qris-demo.png') }}"
                                                            class="img-fluid" style="max-width:250px;">
                                                        <p class="text-muted mt-2">Tunjukkan bukti pembayaran ke admin</p>
                                                    </div> --}}

                                                </div>

                                                {{-- <div class="modal-footer">
                                                    <button class="btn btn-primary">Konfirmasi Pembayaran</button>
                                                </div> --}}
                                                {{-- @if (session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show">
                                                        {{ session('success') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    
                                                @if (session('warning'))
                                                    <div class="alert alert-warning alert-dismissible fade show">
                                                        {{ session('warning') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif --}}
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <script>
                                    function hitungTotal{{ $order->ord_id }}() {
                                        let qty = parseFloat(document.getElementById("quantity{{ $detail->odt_id }}").value) || 0;
                                        let price = {{ $detail->odt_price }};
                                        let total = qty * price;

                                        document.getElementById("totalHarga{{ $order->ord_id }}").value =
                                            "Rp " + total.toLocaleString("id-ID");
                                    }

                                    // jalankan awal kali load
                                    hitungTotal{{ $order->ord_id }}();
                                </script>
                                <script>
                                    function hitTotal{{ $order->ord_id }}() {
                                        let grandTotal = 0;

                                        @foreach ($order->details as $detail)
                                            let qty{{ $detail->odt_id }} = parseFloat(document.getElementById("qty{{ $detail->odt_id }}").value) || 0;
                                            let price{{ $detail->odt_id }} = parseFloat(document.getElementById("price{{ $detail->odt_id }}")
                                                .value) || 0;
                                            grandTotal += qty{{ $detail->odt_id }} * price{{ $detail->odt_id }};
                                        @endforeach

                                        document.getElementById("grandTotal{{ $order->ord_id }}").value =
                                            "Rp " + grandTotal.toLocaleString("id-ID");
                                    }

                                    // Jalankan saat modal pertama kali dibuka
                                    hitTotal{{ $order->ord_id }}();
                                </script>


                                <script>
                                    // function hitungKembalian{{ $order->ord_id }}() {
                                    //     let total = {{ $order->ord_total }};
                                    //     let bayar = parseInt(document.getElementById("jumlahBayar{{ $order->ord_id }}").value) || 0;
                                    //     let kembali = bayar - total;

                                    //     document.getElementById("kembalian{{ $order->ord_id }}").value =
                                    //         "Rp " + kembali.toLocaleString("id-ID");
                                    // }

                                    function toggleMetode(orderId, select) {
                                        let cash = document.getElementById("cashSection" + orderId);
                                        let transfer = document.getElementById("transferSection" + orderId);
                                        let bayar = document.getElementById("jumlahBayar" + orderId);

                                        cash.style.display = "none";
                                        transfer.style.display = "none";
                                        bayar.required = false;

                                        if (select.value === "cash") {
                                            cash.style.display = "block";
                                            bayar.required = true;
                                        }

                                        if (select.value === "transfer") {
                                            transfer.style.display = "block";
                                        }
                                    }



                                    // function formatBayar{{ $order->ord_id }}(input) {
                                    //     let angka = input.value.replace(/[^0-9]/g, '');
                                    //     if (angka) {
                                    //         input.value = "Rp " + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    //     } else {
                                    //         input.value = "";
                                    //     }

                                    //     let total = {{ $order->ord_total }};
                                    //     let bayar = parseInt(angka) || 0;
                                    //     let kembali = bayar - total;

                                    //     document.getElementById("kembalian{{ $order->ord_id }}").value =
                                    //         "Rp " + kembali.toLocaleString("id-ID");
                                    // }
                                </script>
                                <script>
                                    function formatBayar{{ $order->ord_id }}(input) {
                                        // ambil angka saja
                                        let angka = input.value.replace(/[^0-9]/g, '');
                                        let total = {{ $order->ord_total }};

                                        let bayar = parseInt(angka) || 0;

                                        // 🔒 batas maksimal = total harga
                                        // if (bayar > total) {
                                        //     bayar = total;
                                        // }

                                        // format input jumlah bayar
                                        if (bayar > 0) {
                                            input.value = "Rp " + bayar.toLocaleString("id-ID");
                                        } else {
                                            input.value = "";
                                        }

                                        // ➖ kembalian boleh minus (utang)
                                        let kembali = bayar - total;

                                        let kembalianInput = document.getElementById("kembalian{{ $order->ord_id }}");
                                        let infoPiutang = document.getElementById("infoPiutang{{ $order->ord_id }}");
                                        if (kembali < 0) {
                                            kembalianInput.value =
                                                "- Rp " + Math.abs(kembali).toLocaleString("id-ID");
                                            infoPiutang.style.display = "block";
                                        } else {
                                            kembalianInput.value =
                                                "Rp " + kembali.toLocaleString("id-ID");
                                            infoPiutang.style.display = "none";
                                        }
                                    }
                                </script>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <!-- start row -->


                            <tr>
                                <th width="10%">No</th>
                                <th>Invoice</th>
                                <th>Nama Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
function bayarMidtrans(orderId) {
    fetch(`/employee/ordering/${orderId}/midtrans-token`)
        .then(res => res.json())
        .then(data => {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    location.reload();
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran");
                },
                onError: function(result) {
                    alert("Pembayaran gagal");
                }
            });
        });
}
</script>

@endsection



@push('script')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> --}}

    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
    {{-- <script>
    $('#file_export').DataTable({
    scrollX: true,      // WAJIB supaya table bisa digeser
    autoWidth: false,   // Biar kolom gak maksa melebar
});

</script> --}}
    <script>
        var table;
        $(document).ready(function() {
            $(document).on('click', '.change-status', function(e) {
                e.preventDefault();

                var orderId = $(this).data('id');
                var newStatus = $(this).data('status');

                $.ajax({
                    url: '/employee/ordering/' + orderId + '/status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ord_status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {

                            // ====== UPDATE TEKS & WARNA STATUS BUTTON ======
                            var statusButton = $('#statusDropdown' + orderId);

                            var colorMap = {
                                'menunggu': 'btn-warning',
                                'menunggu penjemputan': 'btn-warning',
                                'dalam penjemputan': 'btn-info',
                                'menunggu penyerahan': 'btn-primary',
                                'proses': 'btn-secondary',
                                'menunggu pengantaran': 'btn-primary',
                                'dalam pengantaran': 'btn-info',
                                'menunggu pengambilan': 'btn-primary',
                                'selesai': 'btn-success',
                                'dibatalkan': 'btn-danger'
                            };

                            var newColor = colorMap[response.status.toLowerCase()] ||
                                'btn-secondary';

                            statusButton
                                .text(response.status)
                                .removeClass(
                                    'btn-warning btn-info btn-success btn-danger btn-secondary btn-primary'
                                )
                                .addClass(newColor);
                            var dropdownMenu = statusButton.next('.dropdown-menu');
                            dropdownMenu.empty();

                            response.options.forEach(function(opt) {
                                dropdownMenu.append(`
        <li>
            <a class="dropdown-item change-status"
               href="#"
               data-id="${orderId}"
               data-status="${opt}">
                ${opt}
            </a>
        </li>
    `);
                            });


                            // ====== UPDATE TOMBOL TIMBANG ↔ PEMBAYARAN ======
                            var aksiContainer = $('#button-' + orderId);

                            if (response.paid) {
                                aksiContainer.html(`
        <span class="btn btn-success d-inline-flex align-items-center gap-1"  
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Pembayaran sudah lunas" >
                    <span class="iconify"
                    data-icon="ic:baseline-price-check"
                    data-width="20"></span>
                    </span>

        <a href="/employee/ordering/${orderId}/detail"
            class="btn btn-info"
            data-bs-toggle="tooltip"
            title="Detail Pesanan">
                                                
            <span class="iconify"
                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                data-width="22"
                data-height="22"></span>
        </a>
        <a href="/employee/ordering/${orderId}/destroy"
            class="btn btn-danger"
            data-confirm-delete="true"
            data-bs-toggle="tooltip"
            title="Hapus Pesanan">
            <span class="iconify"
                   data-icon="line-md:file-remove-filled"
                   data-width="22"
                   data-height="22"></span>
        </a>
    `);
                            } else if (response.is_debt) {
                                // 🔥 DP / PIUTANG
                                aksiContainer.html(`
    <a href="/owner/debt/order/${orderId}"
   class="btn btn-danger d-inline-flex align-items-center gap-1"
   data-bs-toggle="tooltip"
   title="Bayar sebagian">

    <span class="iconify"
        data-icon="mdi:cash-clock"
        data-width="20"
        data-height="20"></span>
</a>


        <a href="/employee/ordering/${orderId}/detail"
            class="btn btn-info"
            data-bs-toggle="tooltip"
            title="Detail Pesanan">
                                                
            <span class="iconify"
                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                data-width="22"
                data-height="22"></span>
        </a>
        <a href="/employee/ordering/${orderId}/destroy"
            class="btn btn-danger"
            data-confirm-delete="true"
            data-bs-toggle="tooltip"
            title="Hapus Pesanan">
            <span class="iconify"
                   data-icon="line-md:file-remove-filled"
                   data-width="22"
                   data-height="22"></span>
        </a>
    `);
                            } else if (
                                response.status.toLowerCase() === 'menunggu pengantaran' ||
                                response.status.toLowerCase() === 'menunggu pengambilan' ||
                                response.status.toLowerCase() === 'dalam pengantaran'
                            ) {
                                aksiContainer.html(`
        <button class="btn btn-success"
            data-bs-toggle="modal"
            data-bs-target="#modalBayar${orderId}"
            data-bs-toggle="tooltip"
            title="Pembayaran">
            <span class="iconify"
                data-icon="tabler:user-dollar"
                data-width="20"
                data-height="20"></span>
        </button>

        <a href="/employee/ordering/${orderId}/detail"
            class="btn btn-info"
            data-bs-toggle="tooltip"
            title="Detail Pesanan">
                                                
            <span class="iconify"
                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                data-width="22"
                data-height="22"></span>
        </a>
        <a href="/employee/ordering/${orderId}/destroy"
            class="btn btn-danger"
            data-confirm-delete="true"
            data-bs-toggle="tooltip"
            title="Hapus Pesanan">
            <span class="iconify"
                   data-icon="line-md:file-remove-filled"
                   data-width="22"
                   data-height="22"></span>
        </a>
    `);
                            // 🔥 TIMBANG (BELUM ADA PAYMENT)
} else if (
    response.payment === null &&
    (
        response.status === 'menunggu penjemputan' ||
        response.status === 'dalam penjemputan' ||
        response.status === 'menunggu penyerahan' ||
        response.status === 'proses'
    )
) {

    aksiContainer.html(`
        <button class="btn btn-info d-inline-flex align-items-center justify-content-center"
            data-bs-toggle="modal"
            data-bs-target="#modalTimbang${orderId}"
            data-bs-toggle="tooltip"
            title="Timbang">
            <span class="iconify"
                data-icon="ic:baseline-balance"
                data-width="18"></span>
        </button>

        <a href="/employee/ordering/${orderId}/detail"
            class="btn btn-info"
            data-bs-toggle="tooltip"
            title="Detail Pesanan">
            <span class="iconify"
                data-icon="line-md:text-box-twotone-to-text-box-multiple-twotone-transition"
                data-width="22"></span>
        </a>

        <a href="/employee/ordering/${orderId}/destroy"
            class="btn btn-danger"
            data-confirm-delete="true"
            data-bs-toggle="tooltip"
            title="Hapus Pesanan">
            <span class="iconify"
                data-icon="line-md:file-remove-filled"
                data-width="22"></span>
        </a>
    `);                            }


                        }
                        // ====== KHUSUS STATUS SELESAI ======
if (newStatus.toLowerCase() === 'selesai') {

if (!response.paid && !response.is_debt) {
    alert('❌ Order ini belum dibayar');
    return; // STOP DI SINI, JANGAN LANJUT
}

// ✅ BOLEH SELESAI
$('#order-row-' + orderId).fadeOut(300);
return;
}
                    },
                    error: function(xhr) {  
                        alert('❌ Gagal mengubah status.');
                    }

                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Loop tiap modal (tiap order)
            document.querySelectorAll("[id^='modalTimbang']").forEach(modal => {

                let orderId = modal.id.replace("modalTimbang", "");

                // Saat modal dibuka
                modal.addEventListener("show.bs.modal", function() {

                    // Reset semua nilai ke original
                    modal.querySelectorAll(".qty-input-" + orderId).forEach(input => {
                        input.value = input.dataset.original;
                    });

                    // Hitung ulang total
                    hitTotal(orderId);
                });

                // Saat input berubah
                modal.querySelectorAll(".qty-input-" + orderId).forEach(input => {
                    input.addEventListener("input", () => hitTotal(orderId));
                });

            });

        });

        // Fungsi hitung total
        function hitTotal(orderId) {
            let total = 0;

            document.querySelectorAll("#modalTimbang" + orderId + " .qty-input-" + orderId)
                .forEach(input => {
                    let qty = parseFloat(input.value) || 0;
                    let price = parseFloat(input.dataset.price) || 0;
                    total += qty * price;
                });

            document.getElementById("grandTotal" + orderId).value =
                "Rp " + total.toLocaleString("id-ID");
        }
    </script>
@endpush
