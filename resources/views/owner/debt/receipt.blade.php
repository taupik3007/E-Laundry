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
      width: 70px;
      margin-bottom: 8px;
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

    .total-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 6px;
      font-size: 15px;
      font-weight: 600;
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
  width: 50px;
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
    <img src="{{ asset('assets/images/hero-img/laundry-basket.png') }}">
    <div class="title">Struk Pembayaran</div>
    <div style="font-size:12px; color:#555;">
      Laundry Bersih Selalu • RW 04
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
      <span>Total Tagihan</span>
      <span>
        Rp {{ number_format($payment->order->ord_total - ($payment->pym_discount ?? 0), 0, ',', '.') }}
      </span>
    </div>

    <div class="total-row">
      <span>Sudah Dibayar</span>
      <span>
        Rp {{ number_format($payment->pym_amount, 0, ',', '.') }}
      </span>
    </div>

    <div class="grand-total">
      <span>Sisa Piutang</span>
      <span>
        Rp {{ number_format($payment->pym_debt_amount, 0, ',', '.') }}
      </span>
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
    *Pembayaran dicatat sebagai cicilan/piutang*
  </div>

</div>

<script>
  window.addEventListener("load", function () {
    window.print();
  });
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk Pembayaran</title>

<style>
/* ===============================
   GLOBAL RESET (WAJIB)
================================ */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: Arial, Helvetica, sans-serif;
  background: #fff;
}

/* ===============================
   STRUK CONTAINER
================================ */
.receipt-container {
  width: 72mm;
  max-width: 72mm;
  padding: 6px;
  margin: 0 auto;
}

/* ===============================
   HEADER
================================ */
.header {
  text-align: center;
  border-bottom: 1px dashed #000;
  padding-bottom: 6px;
  margin-bottom: 6px;
}

.header img {
  width: 40px;
  margin-bottom: 4px;
}

.title {
  font-size: 14px;
  font-weight: bold;
}

.subtitle {
  font-size: 10px;
}

/* ===============================
   INFO ROW
================================ */
.info-row {
  display: flex;
  justify-content: space-between;
  font-size: 11px;
  margin-bottom: 2px;
}

/* ===============================
   SECTION TITLE
================================ */
.section-title {
  margin-top: 6px;
  margin-bottom: 4px;
  font-size: 11px;
  font-weight: bold;
  border-bottom: 1px dashed #000;
}

/* ===============================
   ITEM LIST
================================ */
.item {
  display: flex;
  justify-content: space-between;
  font-size: 11px;
  margin-bottom: 2px;
}

.item span:last-child {
  white-space: nowrap;
}

/* ===============================
   TOTAL BOX
================================ */
.total-box {
  margin-top: 6px;
  border-top: 1px dashed #000;
  padding-top: 4px;
}

.total-row {
  display: flex;
  justify-content: space-between;
  font-size: 11px;
  margin-bottom: 2px;
}

.grand-total {
  display: flex;
  justify-content: space-between;
  font-size: 12px;
  font-weight: bold;
  border-top: 1px dashed #000;
  padding-top: 4px;
  margin-top: 4px;
}

/* ===============================
   FOOTER
================================ */
.footer {
  text-align: center;
  font-size: 9px;
  margin-top: 6px;
}

/* ===============================
   PRINT SETTING (PENTING)
================================ */
@media print {

  @page {
    size: 72mm auto;
    margin: 0;
  }

  body {
    margin: 0;
    padding: 0;
  }

  .receipt-container {
    margin: 0;
  }
}
</style>
</head>

<body>

<div class="receipt-container">

  <!-- HEADER -->
  <div class="header">
    <img src="{{ asset('assets/images/hero-img/laundry-basket.png') }}">
    <div class="title">STRUK PEMBAYARAN</div>
    <div class="subtitle">Laundry Bersih Selalu • RW 04</div>
  </div>

  <!-- INFO -->
  <div class="info-row">
    <span>Invoice</span>
    <span>#{{ $payment->order->ord_invoice }}</span>
  </div>

  <div class="info-row">
    <span>Tanggal</span>
    <span>{{ \Carbon\Carbon::parse($payment->created_at)->translatedFormat('d/m/Y') }}</span>
  </div>

  <div class="info-row">
    <span>Pelanggan</span>
    <span>{{ $payment->order->ord_customer_name }}</span>
  </div>

  <!-- DETAIL -->
  <div class="section-title">DETAIL PESANAN</div>

  @foreach ($order->details as $detail)
  <div class="item">
    <span>
      {{ $detail->service->lds_name }}
      {{ $detail->package->ldp_name }}
      {{ $detail->odt_quantity }} {{ $detail->package->ldp_unit }}
    </span>
    <span>
      {{ number_format($detail->odt_total, 0, ',', '.') }}
    </span>
  </div>
  @endforeach

  <!-- TOTAL -->
  <div class="total-box">
    <div class="total-row">
      <span>Total</span>
      <span>
        {{ number_format($payment->order->ord_total - ($payment->pym_discount ?? 0), 0, ',', '.') }}
      </span>
    </div>

    <div class="total-row">
      <span>Dibayar</span>
      <span>{{ number_format($payment->pym_amount, 0, ',', '.') }}</span>
    </div>

    <div class="grand-total">
      <span>Sisa</span>
      <span>{{ number_format($payment->pym_debt_amount, 0, ',', '.') }}</span>
    </div>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    Terima kasih ❤️<br>
    Simpan struk ini sebagai bukti
  </div>

</div>

<script>
window.onload = function () {
  window.print();
};
</script>

</body>
</html>
