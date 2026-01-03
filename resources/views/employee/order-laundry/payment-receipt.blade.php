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
      Jl. Terusan Pahlawan No.94, Sukagalih, Kec. Tarogong Kidul, Kabupaten Garut, Jawa Barat 
    </div>
  </div>

  <!-- INFO TRANSAKSI -->
  <div class="info-row">
    <span>No. Invoice</span>
    <span>#{{ $payment->order->ord_invoice }}</span>
  </div>

  <div class="info-row">
    <span>Tanggal</span>
    <span>
      {{ \Carbon\Carbon::parse($payment->created_at)->translatedFormat('d F Y') }}
    </span>
  </div>

  <div class="info-row">
    <span>Pelanggan</span>
    <span>{{ $payment->order->ord_customer_name }}</span>
  </div>

  <!-- DETAIL PESANAN -->
  <div class="section-title">Detail Pesanan</div>

  @foreach ($order->details as $detail)
  <div class="item">
    <span>
      {{ $detail->service->lds_name }}
      {{ $detail->package->ldp_name }}
      {{ $detail->odt_quantity }} {{ $detail->package->ldp_unit }}
    </span>
    <span>
      Rp {{ number_format($detail->odt_total, 0, ',', '.') }}
    </span>
  </div>
@endforeach

  <!-- RINGKASAN PIUTANG -->
  <div class="total-box">

    <div class="total-row">
      <span>Sub Total</span>
      <span>
        Rp {{ number_format($payment->order->ord_total, 0, ',', '.') }}
      </span>
    </div>

    <div class="total-row">
      <span>Discount</span>
      <span>
        Rp {{ number_format($payment->pym_discount ?? 0, 0, ',', '.') }}
    </span>
    </div>

    <div class="total-row total-bold">
      <span>Total</span>
      <span>
        Rp {{ number_format($payment->order->ord_total - ($payment->pym_discount ?? 0), 0, ',', '.') }}
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
            <span>Sisa Piutang</span>
            <span>Rp {{ number_format($payment->pym_debt_amount, 0, ',', '.') }}</span>
        @else
            <span>Kembali</span>
            <span>Rp {{ number_format($payment->pym_change_amount,0,',','.') }}</span>
        @endif
    </div>
</div> --}}
<div class="payment-summary">
  {{-- RINGKASAN --}}
  {{-- <div class="row">
      <span>Bayar ({{ $payment->getMethodNameAttribute() }})</span>
      <span>Rp {{ number_format($payment->pym_amount, 0, ',', '.') }}</span>
  </div>

  <div class="row">
      <span>Sisa Piutang</span>
      <span class="{{ $payment->pym_debt_amount > 0 ? 'text-danger' : 'text-success' }}">
          Rp {{ number_format($payment->pym_debt_amount, 0, ',', '.') }}
          @if ($payment->pym_debt_amount == 0)
              (Lunas)
          @endif
      </span>
  </div> --}}

  {{-- RIWAYAT CICILAN --}}
  @if ($order->receivablePayments->count() > 0)
  <div class="row">
    <span>Bayar ({{ $payment->getMethodNameAttribute() }})</span>
    <span>Rp {{ number_format($payment->pym_amount, 0, ',', '.') }}</span>
</div>

<div class="row">
    <span>Sisa Piutang</span>
    <span class="{{ $payment->pym_debt_amount > 0 ? 'text-danger' : 'text-success' }}">
        Rp {{ number_format($payment->pym_debt_amount, 0, ',', '.') }}
        @if ($payment->pym_debt_amount == 0)
            (Lunas)
        @endif
    </span>
</div>
      <hr>
      <div class="section-title">Riwayat Pembayaran</div>

      @foreach ($order->receivablePayments as $rp)
          <div class="border rounded p-2 mb-2 small">

              <div class="d-flex justify-content-between total-bold">
                <strong>
                  {{ \Carbon\Carbon::parse($rp->rp_paid_at)->format('d/m/Y') }}
              </strong>
                  <br>
                  <div class="row">
                  {{-- <span>Bayar{{ number_format($rp->rp_amount_paid, 0, ',', '.') }}</span> --}}
                  <span>Bayar ({{ $payment->getMethodNameAttribute() }})</span>
                  <span>Rp {{ number_format($rp->rp_amount_paid, 0, ',', '.') }}</span>
                </div>
                <div class="row">
                  <span>Sisa Piutang</span>
                  <span>
                      Rp {{ number_format($rp->rp_remaining, 0, ',', '.') }}
                      @if ($rp->rp_remaining == 0)
                          <strong class="text-success">(Lunas)</strong>
                      @endif
                  </span>
                </div>
              </div>
              {{-- <div class="d-flex justify-content-between">
                  <span>Sisa Piutang</span>
                  <span>
                      Rp {{ number_format($rp->rp_remaining, 0, ',', '.') }}
                      @if ($rp->rp_remaining == 0)
                          <strong class="text-success">(Lunas)</strong>
                      @endif
                  </span>
              </div> --}}

          </div>
      @endforeach
      @else
        <div class="row">
          <span>Bayar ({{ $payment->getMethodNameAttribute() }})</span>
          <span>Rp {{ number_format($payment->pym_cash_received,0,',','.') }}</span>
        </div>
      <div class="row">
        <span>Kembali</span>
            <span>Rp {{ number_format($payment->pym_change_amount,0,',','.') }}</span>
      </div>

    </div>

  @endif

</div>



  </div>

  <!-- QRIS (opsional, muncul kalau masih ada piutang) -->
  {{-- @if($payment->pym_debt_amount > 0)
  <div class="qris-box">
    <p style="font-size:14px; color:#444;">
      Metode Pembayaran: <b>{{ strtoupper($payment->pym_method ?? 'CASH') }}</b>
    </p>
    <img src="https://i.ibb.co/bK9syjC/qr-sample.png">
    <p style="font-size:12px;color:#777;">
      Scan untuk pembayaran selanjutnya
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
