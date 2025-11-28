@extends('owner.master')

@section('title')
    Pembayaran QRIS
@endsection

@section('content')

<div class="container-fluid py-4">

    {{-- Judul Halaman --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold">Pembayaran Order</h4>
            <p class="text-muted mb-0">Halaman pembayaran QRIS</p>
        </div>
    </div>

    {{-- CARD ORDER DETAIL --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Detail Order</strong>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>ID Order:</strong> ORD-{{ $payment->order->ord_id }}</p>
                    <p class="mb-1"><strong>Nama Customer:</strong> {{ $payment->order->ord_customer_name }}</p>
                    <p class="mb-1"><strong>Layanan:</strong> {{ $payment->order->package->ldp_name }}</p>
                </div>

                <div class="col-md-6">
                    <p class="mb-1"><strong>Berat:</strong>
                        {{ $payment->order->ord_quantity }} {{ $payment->order->package->ldp_unit }}
                    </p>

                    <p class="mb-1"><strong>Total:</strong>
                        Rp {{ number_format($payment->order->ord_total, 0, ',', '.') }}
                    </p>

                    <p class="mb-1"><strong>Status:</strong>
                        @if($payment->pym_payment_status == 1)
                            <span class="badge bg-success">Sudah Bayar</span>
                        @else
                            <span class="badge bg-warning">Belum Bayar</span>
                        @endif
                    </p>
                </div>
            </div>

        </div>
    </div>

    {{-- CARD QRIS --}}
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <strong>QRIS Pembayaran</strong>
        </div>

        <div class="card-body text-center">

            <p class="fw-bold mb-3">Scan QRIS di bawah untuk melakukan pembayaran</p>

            {{-- QR MIDTRANS --}}
            <img src="{{ $payment->pym_qrcode_url }}"
                 class="img-fluid mb-3 border rounded p-2"
                 style="max-width: 260px;">

            <p class="text-muted mb-1">Nominal yang harus dibayar:</p>

            <h4 class="fw-bold">
                Rp {{ number_format($payment->order->ord_total, 0, ',', '.') }}
            </h4>

            {{-- Tombol copy payload --}}
            <button class="btn btn-outline-primary mt-3"
                    onclick="navigator.clipboard.writeText('{{ $payment->pym_qrcode_url }}')">
                Salin Payload
            </button>
        </div>
    </div>

</div>

@endsection
