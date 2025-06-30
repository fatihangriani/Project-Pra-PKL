<?php
include '../home/koneksi.php';
$tanggal = date('Y-m-d');
$data = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jumlah, COALESCE(SUM(total_harga),0) AS total
     FROM transaksi WHERE DATE(tanggal_transaksi)='$tanggal'"));
?>

<!DOCTYPE html>
<html>
<head>
  <title>Laporan Harian</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 50%; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .btn { margin-top: 20px; padding: 10px 15px; background: blue; color: white; cursor: pointer; }
  </style>
</head>
<body>
  <h2>Laporan Pendapatan Harian</h2>
  <p>Tanggal: <?= date('d M Y', strtotime($tanggal)) ?></p>
  <table>
    <tr><th>Jumlah Transaksi</th><td><?= $data['jumlah'] ?></td></tr>
    <tr><th>Total Pendapatan</th><td>Rp <?= number_format($data['total'], 0, ',', '.') ?></td></tr>
  </table>
  <button onclick="window.print()" class="btn">Cetak / Simpan sebagai PDF</button>
</body>
</html>
