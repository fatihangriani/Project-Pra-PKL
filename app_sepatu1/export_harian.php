<?php
require('../fpdf/fpdf.php');
include '../home/koneksi.php';

$tanggal = date('Y-m-d');
$data = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jumlah, COALESCE(SUM(total_harga),0) AS total
     FROM transaksi WHERE DATE(tanggal_transaksi)='$tanggal'"));

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,"Laporan Pendapatan Harian",0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Ln(10);

$pdf->Cell(60,10,'Tanggal',1);
$pdf->Cell(60,10,date('d M Y', strtotime($tanggal)),1,1);

$pdf->Cell(60,10,'Jumlah Transaksi',1);
$pdf->Cell(60,10,$data['jumlah'],1,1);

$pdf->Cell(60,10,'Total Pendapatan',1);
$pdf->Cell(60,10,'Rp '.number_format($data['total'],0,',','.'),1,1);

$pdf->Output('D',"pendapatan_harian_$tanggal.pdf");
