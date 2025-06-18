<?php
include '../home/koneksi.php';
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=pendapatan_bulanan_".date('Y').".csv");

$output = fopen("php://output","w");
fputcsv($output,["Bulan","Pendapatan (Rp)"]);

$tahun = date('Y');
$bulan = [1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",5=>"Mei",6=>"Juni",
          7=>"Juli",8=>"Agustus",9=>"September",10=>"Oktober",11=>"November",12=>"Desember"];

$q = mysqli_query($koneksi,"SELECT MONTH(tanggal_transaksi) AS bln,
                                   SUM(total_harga)        AS total
                            FROM transaksi
                            WHERE YEAR(tanggal_transaksi)='$tahun'
                            GROUP BY MONTH(tanggal_transaksi)");
$data = array_fill(1,12,0);
while($r=mysqli_fetch_assoc($q)){ $data[$r['bln']]=$r['total']; }

foreach($data as $i=>$tot){
  fputcsv($output,[$bulan[$i]." ".$tahun,$tot]);
}
fclose($output);
