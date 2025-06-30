<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['admin'])) {
  echo "<script>alert('Silakan login terlebih dahulu.');window.location='login_admin.php';</script>";
  exit;
}
include '../home/koneksi.php';

/* ---------- statistik ringkas ---------- */
$jumlah_produk    = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_barang FROM barang"));
$jumlah_admin     = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_user FROM users WHERE role='admin'"));
$jumlah_pelanggan = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_user FROM users WHERE role='pelanggan'"));
$jumlah_pesanan   = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_transaksi FROM transaksi"));

/* ---------- pendapatan bulanan (tahun berjalan) ---------- */
$tahun      = date('Y');
$bulan_nama = ['Januari','Februari','Maret','April','Mei','Juni','Juli',
               'Agustus','September','Oktober','November','Desember'];

$data_bulan       = array_map(fn($b)=>"$b $tahun",$bulan_nama);
$data_pendapatan  = array_fill(0,12,0);

$q = mysqli_query($koneksi,"SELECT MONTH(tanggal_transaksi) AS bln,
                                   SUM(total_harga)         AS total
                            FROM transaksi
                            WHERE YEAR(tanggal_transaksi)='$tahun'
                            GROUP BY MONTH(tanggal_transaksi)");
while($r = mysqli_fetch_assoc($q)){
  $idx = $r['bln'] - 1;
  $data_pendapatan[$idx] = (float)$r['total'];
}

/* ---------- pendapatan hari ini ---------- */
$today   = date('Y-m-d');
$harian  = mysqli_query($koneksi,
            "SELECT COUNT(*) AS jumlah, COALESCE(SUM(total_harga),0) AS total
             FROM transaksi WHERE DATE(tanggal_transaksi)='$today'");
$harian  = mysqli_fetch_assoc($harian);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<style>
/* ——— gaya singkat (dipotong) ——— */
:root{--primary:#4361ee;--info:#4895ef;--success:#10b981;--warning:#f8961e;--gray:#6c757d;--dark:#212529;--white:#ffffff;--card-shadow:0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -1px rgba(0,0,0,.06)}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f8fafc;display:flex;min-height:100vh;color:#334155}
/* sidebar */
.sidebar{width:250px;background:linear-gradient(135deg,#4361ee,#3a0ca3);color:#fff;padding:20px 0;position:fixed;height:100vh;overflow-y:auto}
.sidebar h2{text-align:center;margin-bottom:30px;padding-bottom:15px;border-bottom:1px solid rgba(255,255,255,.2)}
.sidebar ul{list-style:none;padding:0 20px}.sidebar ul li{margin-bottom:10px}
.sidebar a{color:#fff;text-decoration:none;display:block;padding:12px 15px;border-radius:5px;font-size:15px;transition:.3s}
.sidebar a i{margin-right:10px;width:20px;text-align:center}
.sidebar a:hover{background:rgba(255,255,255,.1);transform:translateX(5px)}
.sidebar a.active{background:rgba(255,255,255,.2);font-weight:500}
.menu-bawah{margin-top:30px;padding:0 20px}.menu-bawah .logout{display:block;text-align:center;background:rgba(255,255,255,.1);padding:12px;border-radius:5px;color:#fff}
/* content */
.content{flex:1;margin-left:250px;padding:2rem;display:flex;flex-direction:column}
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;border-bottom:1px solid #e2e8f0;padding-bottom:1rem}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;margin-bottom:2rem}
.stat-card{background:#fff;border-radius:.75rem;box-shadow:var(--card-shadow);padding:1.5rem;border-left:4px solid var(--primary);display:flex;flex-direction:column}
.stat-card h3{display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;font-size:1rem;color:var(--gray)}
.stat-card .value{font-size:1.75rem;font-weight:700;color:var(--dark)}
.chart-container{height:400px;min-height:300px}
.chart-container canvas{width:100%!important;height:100%!important;min-height:300px}
.table-report{width:100%;border-collapse:collapse;margin-top:20px}
.table-report th,.table-report td{border:1px solid #ccc;padding:10px;text-align:center}
.table-report th{background:#e2e8f0}
.btn-download{display:inline-block;margin-right:10px;padding:10px 20px;border-radius:6px;color:#fff;text-decoration:none;font-size:.9rem}
.btn-month{background:#4895ef}.btn-day{background:#10b981}
</style>
</head><body>

<!-- ── Sidebar ─────────────────────────── -->
<div class="sidebar">
  <h2>Panel Admin</h2>
  <ul>
    <li><a class="active" href="#"><i class="fas fa-chart-line"></i><span>Dashboard</span></a></li>
    <li><a href="akun.php"><i class="fas fa-user-cog"></i><span>Kelola Akun</span></a></li>
    <li><a href="produk.php"><i class="fas fa-shopping-cart"></i><span>Kelola Produk</span></a></li>
    <li><a href="pembayaran.php"><i class="fas fa-credit-card"></i><span>Kelola Pembayaran</span></a></li>
    <li><a href="pesanan.php"><i class="fas fa-box"></i><span>Kelola Pesanan</span></a></li>
    <li><a href="pelanggan.php"><i class="fas fa-users"></i><span>Kelola Pengguna</span></a></li>
    <li><a href="pesan.php"><i class="fas fa-comments"></i><span>Kelola Komentar</span></a></li>
  </ul>
  <div class="menu-bawah">
    <a href="logout_admin.php" class="logout"><i class="fas fa-sign-out-alt"></i>Keluar</a>
  </div>
</div>

<!-- ── Main Content ────────────────────── -->
<div class="content">
  <div class="header">
    <h1>Dashboard Admin</h1>
    <div><span id="current-date"></span></div>
  </div>

  <!-- stats -->
  <div class="stats-grid">
    <div class="stat-card" style="border-left-color:var(--primary)">
      <h3><i class="fas fa-box-open" style="color:var(--primary)"></i>Total Produk</h3>
      <div class="value"><?= number_format($jumlah_produk) ?></div>
    </div>
    <div class="stat-card" style="border-left-color:var(--info)">
      <h3><i class="fas fa-user-shield" style="color:var(--info)"></i>Total Admin</h3>
      <div class="value"><?= number_format($jumlah_admin) ?></div>
    </div>
    <div class="stat-card" style="border-left-color:var(--success)">
      <h3><i class="fas fa-users" style="color:var(--success)"></i>Total Pelanggan</h3>
      <div class="value"><?= number_format($jumlah_pelanggan) ?></div>
    </div>
    <div class="stat-card" style="border-left-color:var(--warning)">
      <h3><i class="fas fa-shopping-basket" style="color:var(--warning)"></i>Total Pesanan</h3>
      <div class="value"><?= number_format($jumlah_pesanan) ?></div>
    </div>
  </div>

  <!-- chart -->
  <div class="chart-container">
    <h3><i class="fas fa-chart-area"></i> Statistik Pendapatan Bulanan</h3>
    <canvas id="pendapatanChart"></canvas>
  </div>
<br><br>
  <!-- tombol download -->
<div style="margin-top:20px">
  <a href="export_pendapatan.php" onclick="downloadPDF()" class="btn-download btn-month">
    <i class="fas fa-file-pdf"></i> Simpan Grafik Perbulan
  </a>
  <a href="export_harian.php" class="btn-download btn-day">
    <i class="fas fa-file-pdf"></i> Simpan Laporan Harian
  </a>
</div>

  <!-- laporan harian -->
  <h3 style="margin-top:40px"><i class="fas fa-calendar-day"></i> Laporan Pendapatan Hari Ini</h3>
  <table class="table-report">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Jumlah Transaksi</th>
        <th>Total Pendapatan</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= date('d M Y', strtotime($today)) ?></td>
        <td><?= $harian['jumlah'] ?></td>
        <td>Rp <?= number_format($harian['total'],0,',','.') ?></td>
      </tr>
    </tbody>
  </table>
</div><!-- /content -->

<script>
/* tampilkan tanggal hari ini */
document.getElementById('current-date').textContent =
  new Date().toLocaleDateString('id-ID',
    {weekday:'long',year:'numeric',month:'long',day:'numeric'});

/* chart.js */
const ctx  = document.getElementById('pendapatanChart').getContext('2d');
new Chart(ctx,{
  type:'bar',
  data:{
    labels:<?= json_encode($data_bulan) ?>,
    datasets:[{
      label:'Pendapatan (Rp)',
      data:<?= json_encode($data_pendapatan) ?>,
      backgroundColor:'rgba(67,97,238,.7)',
      borderRadius:6,
      barThickness:30
    }]
  },
  options:{
    responsive:true,maintainAspectRatio:false,
    plugins:{tooltip:{callbacks:{label:c=>('Rp '+c.raw.toLocaleString('id-ID'))}}},
    scales:{y:{beginAtZero:true,ticks:{callback:v=>'Rp '+v.toLocaleString('id-ID')}}}
  }
});
async function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const canvas = await html2canvas(document.querySelector(".chart-container"));
  const imgData = canvas.toDataURL("image/png");

  const pdf = new jsPDF({ orientation: 'landscape' });
  pdf.text("Grafik Pendapatan Bulanan", 10, 10);
  pdf.addImage(imgData, 'PNG', 10, 20, 270, 130);
  pdf.save("grafik-pendapatan.pdf");
}

</script>
</body></html>
