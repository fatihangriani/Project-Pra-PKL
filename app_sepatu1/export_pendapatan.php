<?php
require('../fpdf/fpdf.php'); // pastikan folder fpdf sudah ada
include '../home/koneksi.php';

$tahun = date('Y');
$bulan_nama = ['Januari','Februari','Maret','April','Mei','Juni','Juli',
               'Agustus','September','Oktober','November','Desember'];

// ambil data dari database
$data = array_fill(0, 12, 0);
$q = mysqli_query($koneksi, "SELECT MONTH(tanggal_transaksi) AS bln, SUM(total_harga) AS total 
                             FROM transaksi WHERE YEAR(tanggal_transaksi)='$tahun'
                             GROUP BY MONTH(tanggal_transaksi)");
while($r = mysqli_fetch_assoc($q)) {
    $idx = $r['bln'] - 1;
    $data[$idx] = $r['total'];
}

// mulai PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,"Laporan Pendapatan Bulanan - $tahun",0,1,'C');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'No',1);
$pdf->Cell(60,10,'Bulan',1);
$pdf->Cell(60,10,'Pendapatan (Rp)',1);

$pdf->SetFont('Arial','',12);
$total_semua = 0;
foreach($bulan_nama as $i => $nama){
    $pdf->Ln();
    $pdf->Cell(10,10,$i+1,1);
    $pdf->Cell(60,10,$nama,1);
    $pdf->Cell(60,10,number_format($data[$i],0,',','.'),1);
    $total_semua += $data[$i];
}

$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(70,10,'Total',1);
$pdf->Cell(60,10,'Rp '.number_format($total_semua,0,',','.'),1);

$pdf->Output('D',"pendapatan_bulanan_$tahun.pdf"); // 'D' untuk download
