<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Pembayaran</title>

  <style>
    body {
      background: #f4f6f9;
      font-family: "Inter", sans-serif;
      padding: 20px;
    }

    .receipt-container {
      max-width: 420px;
      margin: auto;
      background: #ffffff;
      padding: 25px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      border: 1px solid #e6e9ef;
    }

    .header {
      text-align: center;
      border-bottom: 1px dashed #d0d4da;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }

    .header img {
      width: 150px;
      margin-bottom: 2px;
    }

    .title {
      font-size: 20px;
      font-weight: 700;
      color: #333;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 6px;
      font-size: 14px;
    }

    .section-title {
      margin-top: 20px;
      font-weight: 600;
      color: #444;
      font-size: 15px;
      border-bottom: 1px dashed #d0d4da;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }

    .item {
      display: flex;
      justify-content: space-between;
      margin: 4px 0;
      font-size: 14px;
    }

    .total-box {
      margin-top: 18px;
      padding: 15px;
      background: #f8fafc;
      border-radius: 12px;
      border: 1px solid #e5e7eb;
    }

    .total-row.total-bold {
    font-weight: bold;
    font-size: 14px; /* opsional biar lebih tegas */
}

.total-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    font-weight: normal;
    margin: 8px 0;
}

    .grand-total {
      display: flex;
      justify-content: space-between;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 2px dashed #cbd5e1;
      font-size: 17px;
      font-weight: 700;
      color: #000;
    }
    .divider {
    border-top: 1px dashed #999;
    margin: 8px 0;
}

.payment-summary .row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    margin: 8px 0;
}


    .qris-box {
      text-align: center;
      margin-top: 25px;
    }

    .qris-box img {
      width: 150px;
    }

    .footer {
      text-align: center;
      margin-top: 25px;
      font-size: 12px;
      color: #777;
    }
    @media print {

@page {
  size: 80mm auto;   /* ukuran kertas struk */
  margin: 0;
}

body {
  background: #fff;
  padding: 0;
}

.receipt-container {
  width: 80mm;
  max-width: 80mm;
  margin: 0;
  padding: 10px;
  border-radius: 0;
  box-shadow: none;
  border: none;
}

.header img {
  width: 100px;
}

.title {
  font-size: 16px;
}

.info-row,
.item,
.total-row {
  font-size: 12px;
}

.grand-total {
  font-size: 14px;
}

.footer {
  font-size: 10px;
}

}

  </style>
  
</head>

<body>

<div class="receipt-container">

  <!-- HEADER -->
  <div class="header">
    <img src="{{ asset('assets/images/logos/logooo.png')}}">
    <div class="title">Garut Laundry</div>
    <div style="font-size:12px; color:#555;">
      <b>Jl. Terusan Pahlawan No.94, Sukagalih, Kec. Tarogong Kidul, Kabupaten Garut, Jawa Barat </b>
    </div>
  </div>

  <!-- INFO TRANSAKSI -->
  <div class="info-row">
    <span><b>No. Invoice</b></span>
    <span><b>#{{ $payment->order->ord_invoice }}</b></span>
  </div>

  <div class="info-row">
    <span><b>Tanggal</b></span>
    <span>
      <b>{{ \Carbon\Carbon::parse($payment->created_at)->translatedFormat('d F Y') }} </b>
    </span>
  </div>

  <div class="info-row">
    <span><b>Pelanggan</b></span>
    <span><b>{{ $payment->order->ord_customer_name }}</b></span>
  </div>

  <!-- DETAIL PESANAN -->
  <div class="section-title">Detail Pesanan</div>

  @foreach ($order->details as $detail)
  <div class="item">
    <span><b>
      {{ $detail->service->lds_name }}
      {{ $detail->package->ldp_name }}
      {{ $detail->odt_quantity }} {{ $detail->package->ldp_unit }}</b>
    </span>
    <span>
     <b> Rp {{ number_format($detail->odt_total, 0, ',', '.') }}</b>
    </span>
  </div>
@endforeach

  <!-- RINGKASAN PIUTANG -->
  <div class="total-box">

    <div class="total-row">
      <span><b>Sub Total</b></span>
      <span>
        <b>Rp {{ number_format($payment->order->ord_total, 0, ',', '.') }}</b>
      </span>
    </div>

    <div class="total-row">
      <span><b>Discount</b></span>
      <span>
        <b>{{$payment->pym_discount}}</b>
    </span>
    </div>

    <div class="total-row total-bold">
      <span><b>Total</b></span>
      <span>
        <b>Rp {{ number_format($payment->pym_amount_paid, 0, ',', '.') }}</b>
      </span>
    </div>

    <hr class="divider">

{{-- <div class="payment-summary">
    <div class="row">
        <span>Bayar ({{ $payment->getMethodNameAttribute() }})</span>
        <span>Rp {{ number_format($payment->pym_cash_received,0,',','.') }}</span>
    </div>

    <div class="row">
        @if($payment->pym_is_debt)
            <span><b>Sisa Piutang</b></span>
            <span><b>Rp {{ number_format($payment->pym_debt_amount, 0, ',', '.') }}</b></span>
        @else
            <span><b>Kembali</b></span>
            <span><b>Rp {{ number_format($payment->pym_change_amount,0,',','.') }}</b></span>
        @endif
    </div>
</div> --}}
<div class="payment-summary">
  {{-- RINGKASAN --}}
  {{-- <div class="row">
      <span><b>Bayar ({{ $payment->getMethodNameAttribute() }})</b></span>
      <span><b>Rp {{ number_format($payment->pym_amount, 0, ',', '.') }}</b></span>
  </div>

  <div class="row">
      <span><b>Sisa Piutang</b></span>
      <span class="{{ $payment->pym_debt_amount > 0 ? 'text-danger' : 'text-success' }}">
          <b>Rp {{ number_format($payment->pym_debt_amount, 0, ',', '.') }}</b>
          @if ($payment->pym_debt_amount == 0)
              (Lunas)
          @endif
      </span>
  </div> --}}

  {{-- RIWAYAT CICILAN --}}
  @if ($order->receivablePayments->count() > 0)
  <div class="row">
    <span><b>Bayar ({{ $payment->getMethodNameAttribute() }})</b></span>
    <span><b>Rp {{ number_format($payment->pym_amount, 0, ',', '.') }}</b></span>
</div>

<div class="row">
    <span><b>Sisa Piutang</b></span>
    <span class="{{ $payment->pym_debt_amount > 0 ? 'text-danger' : 'text-success' }}">
        <b>Rp {{ number_format($payment->pym_debt_amount, 0, ',', '.') }}</b>
        @if ($payment->pym_debt_amount == 0)
            (Lunas)
        @endif
    </span>
</div>
      <hr>
      <div class="section-title"><b>Riwayat Pembayaran</b></div>

      @foreach ($order->receivablePayments as $rp)
          <div class="border rounded p-2 mb-2 small">

              <div class="d-flex justify-content-between total-bold">
                <strong style="font-size: 12px;">
                  <b>{{ \Carbon\Carbon::parse($rp->rp_paid_at)->format('d/m/Y') }}</b>
              </strong>
                  <br>
                  <div class="row">
                  {{-- <span><b>Bayar{{ number_format($rp->rp_amount_paid, 0, ',', '.') }}</b></span> --}}
                  <span><b>Bayar ({{ $payment->getMethodNameAttribute() }})</b></span>
                  <span><b>Rp {{ number_format($rp->rp_amount_paid, 0, ',', '.') }}</b></span>
                </div>
                <div class="row">
                  <span><b>Sisa Piutang</b></span>
                  <span>
                     <b> Rp {{ number_format($rp->rp_remaining, 0, ',', '.') }}</b>
                      @if ($rp->rp_remaining == 0)
                          <strong class="text-success">(Lunas)</strong>
                      @endif
                  </span>
                </div>
              </div>
              {{-- <div class="d-flex justify-content-between">
                  <span><b>Sisa Piutang</b></span>
                  <span>
                     <b> Rp {{ number_format($rp->rp_remaining, 0, ',', '.') }}</b>
                      @if ($rp->rp_remaining == 0)
                          <strong class="text-success">(Lunas)</strong>
                      @endif
                  </span>
              </div> --}}

          </div>
      @endforeach
      @else
        <div class="row">
          <span><b>Bayar ({{ $payment->getMethodNameAttribute() }})</b></span>
          <span><b>Rp {{ number_format($payment->pym_cash_received,0,',','.') }}</b></span>
        </div>
      <div class="row">
        <span><b>Kembali</b></span>
            <span><b>Rp {{ number_format($payment->pym_change_amount,0,',','.') }}</b></span>
      </div>

    </div>

  @endif

</div>



  </div>

  <!-- QRIS (opsional, muncul kalau masih ada piutang) -->
  {{-- @if($payment->pym_debt_amount > 0)
  <div class="qris-box">
    <p style="font-size:14px; color:#444;">
     <b> Metode Pembayaran: <b>{{ strtoupper($payment->pym_method ?? 'CASH') }}</b>
    </p>
    <img src="https://i.ibb.co/bK9syjC/qr-sample.png">
    <p style="font-size:12px;color:#777;">
     <b> Scan untuk pembayaran selanjutnya</b>
    </p>
  </div>
  @endif --}}

  <!-- FOOTER -->
  <div class="footer">
    Terima kasih telah menggunakan layanan kami ❤️<br>
    {{-- *Pembayaran dicatat sebagai cicilan/piutang* --}}
  </div>

</div>

<script>
  window.addEventListener("load", function () {
    window.print();
  });
</script>

</body>
</html>
