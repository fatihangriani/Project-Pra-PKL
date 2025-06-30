<?php
include '../home/koneksi.php';

$tahun = date('Y');
$bulan_nama = ['Januari','Februari','Maret','April','Mei','Juni','Juli',
               'Agustus','September','Oktober','November','Desember'];

// Ambil data dari database
$data = array_fill(0, 12, 0);
$q = mysqli_query($koneksi, "SELECT MONTH(tanggal_transaksi) AS bln, SUM(total_harga) AS total 
                             FROM transaksi 
                             WHERE YEAR(tanggal_transaksi) = '$tahun'
                             GROUP BY MONTH(tanggal_transaksi)");
while($r = mysqli_fetch_assoc($q)) {
    $idx = $r['bln'] - 1;
    $data[$idx] = $r['total'];
}
$total_semua = array_sum($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pendapatan Bulanan</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { text-align: center; margin-bottom: 30px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
    .btn-print {
      display: inline-block;
      background-color: #4CAF50;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    .total-row td {
      font-weight: bold;
      background-color: #e0f7fa;
    }
    @media print {
      .btn-print { display: none; }
    }
  </style>
</head>
<body>
  <h2>Laporan Pendapatan Bulanan - <?= $tahun ?></h2>
  <a href="#" class="btn-print" onclick="window.print()">🖨 Cetak PDF</a>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Bulan</th>
        <th>Pendapatan (Rp)</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($bulan_nama as $i => $nama): ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td><?= $nama ?></td>
        <td><?= number_format($data[$i], 0, ',', '.') ?></td>
      </tr>
      <?php endforeach; ?>
      <tr class="total-row">
        <td colspan="2">Total</td>
        <td>Rp <?= number_format($total_semua, 0, ',', '.') ?></td>
      </tr>
    </tbody>
  </table>
</body>
</html>
