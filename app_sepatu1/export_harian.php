<?php
include '../home/koneksi.php';
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=pendapatan_harian_".date('Y-m-d').".csv");

$output = fopen("php://output","w");
fputcsv($output,["Tanggal","Jumlah Transaksi","Total Pendapatan (Rp)"]);

$today = date('Y-m-d');
$q = mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah,
                                   COALESCE(SUM(total_harga),0) AS total
                            FROM transaksi WHERE DATE(tanggal_transaksi)='$today'");
$d = mysqli_fetch_assoc($q);

fputcsv($output,[date('d-m-Y',strtotime($today)),$d['jumlah'],$d['total']]);
fclose($output);
