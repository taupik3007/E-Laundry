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
  </style>
</head>
<body>

  <div class="receipt-container">
    <div class="header">
      <img src="https://cdn-icons-png.flaticon.com/512/891/891462.png">
      <div class="title">Struk Pembayaran</div>
      <div style="font-size:12px; color:#555;">Laundry Bersih Selalu • RW 04</div>
    </div>

    <!-- Info Transaksi -->
    <div class="info-row">
      <span>No. Pesanan</span>
      <span>#ORD-2025-00123</span>
    </div>
    <div class="info-row">
      <span>Tanggal</span>
      <span>25 Nov 2025</span>
    </div>
    <div class="info-row">
      <span>Pelanggan</span>
      <span>Eka Wariah</span>
    </div>

    <!-- Rincian Item -->
    <div class="section-title">Detail Pesanan</div>

    <div class="item">
      <span>Cuci Kering</span>
      <span>Rp 8.000</span>
    </div>
    <div class="item">
      <span>Lipat Premium</span>
      <span>Rp 5.000</span>
    </div>

    <div class="total-box">
      <div class="total-row">
        <span>Subtotal</span>
        <span>Rp 13.000</span>
      </div>
      <div class="total-row">
        <span>Discount</span>
        <span>Rp 0</span>
      </div>
      <div class="grand-total">
        <span>Total Bayar</span>
        <span>Rp 13.000</span>
      </div>
    </div>

    <!-- QRIS -->
    <div class="qris-box">
      <p style="font-size:14px; color:#444;">Metode Pembayaran: <b>QRIS</b></p>
      <img src="https://i.ibb.co/bK9syjC/qr-sample.png">
      <p style="font-size:12px;color:#777;">Scan untuk melihat bukti pembayaran</p>
    </div>

    <div class="footer">
      Terima kasih telah menggunakan layanan kami ❤️<br>
      *Barang yang sudah diambil tidak bisa dikomplain*
    </div>

  </div>

</body>
</html>
