<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login sebagai admin.');window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

/*─ ambil id pembayaran ─*/
$id_pembayaran = $_GET['id'] ?? '';
if (!$id_pembayaran) {
    echo "<script>alert('ID pembayaran tidak ditemukan.');window.location='pembayaran.php';</script>"; exit;
}

/*─ query detail ─*/
$sql = "SELECT
          pembayaran.*,
          pembayaran.status_pembayaran,
          transaksi.total_harga, transaksi.tanggal_transaksi,
          transaksi.status AS status,
          users.username AS nama_user,
          users.email
        FROM pembayaran pembayaran
        JOIN transaksi transaksi ON pembayaran.id_transaksi = transaksi.id_transaksi
        JOIN users     users ON transaksi.id_user      = users.id_user
        WHERE pembayaran.id_pembayaran = '$id_pembayaran'";
$qr  = mysqli_query($koneksi,$sql);
$data= mysqli_fetch_assoc($qr);
if(!$data){
    echo "<script>alert('Data tidak ditemukan.');window.location='pembayaran.php';</script>"; exit;
}

/* fungsi untuk memberi class css */
function badgeClass($s){
  $s = strtolower($s);
  $s = str_replace(' ', '-', $s);   // spasi -> dash
  return "status-{$s}";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Detail Pembayaran</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root{--primary:#4e73df;--dark:#5a5c69}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f8f9fc;color:#333}
.container{max-width:1000px;margin:2rem auto;padding:0 20px}
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem}
h2{color:var(--dark);font-weight:600;border-bottom:2px solid var(--primary);padding-bottom:.5rem}
.btn{padding:10px 20px;background:var(--primary);color:#fff;border-radius:5px;text-decoration:none;font-size:14px}
.btn:hover{background:#2e59d9}
.card{background:#fff;border-radius:10px;box-shadow:0 0.15rem 1rem rgba(0,0,0,.1);padding:2rem}
.table-detail{width:100%;border-collapse:collapse}
.table-detail th,.table-detail td{padding:12px 15px;text-align:left;border-bottom:1px solid #e3e6f0}
.table-detail th{width:30%;background:#f8f9fc;font-weight:500;color:var(--dark)}
.status{display:inline-block;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:500;text-transform:capitalize}
/* badge warna */
.status-menunggu-konfirmasi,
.status-menunggu,
.status-menunggu-pembayaran{background:#fff3cd;color:#856404}
.status-diproses,
.status-dikirim,
.status-selesai,
.status-lunas{background:#d4edda;color:#155724}
.status-ditolak,
.status-dibatalkan{background:#f8d7da;color:#721c24}
.bukti-container{margin-top:10px;border:1px solid #ddd;padding:10px;border-radius:5px;background:#f9f9f9}
.bukti-container img{max-width:100%;height:auto;border-radius:3px}
@media(max-width:768px){
  .table-detail th,.table-detail td{display:block;width:100%}
  .table-detail tr{display:block;margin-bottom:15px;border-bottom:2px solid #e3e6f0}
}
</style>
</head>
<body>
<div class="container">

  <div class="header">
    <h2>Detail Pembayaran</h2>
    <a href="pembayaran.php" class="btn">Kembali</a>
  </div>

  <div class="card">
    <table class="table-detail">
      <tr><th>Nama Pengguna</th><td><?= htmlspecialchars($data['nama_user']) ?></td></tr>
      <tr><th>Email</th><td><?= htmlspecialchars($data['email']) ?></td></tr>
      <tr><th>ID Transaksi</th><td>#<?= $data['id_transaksi'] ?></td></tr>
      <tr><th>Tanggal Transaksi</th><td><?= date('d F Y H:i',strtotime($data['tanggal_transaksi'])) ?></td></tr>
      <tr><th>Total Harga</th><td><strong>Rp<?= number_format($data['total_harga'],0,',','.') ?></strong></td></tr>
      <tr><th>Metode Pembayaran</th><td><?= strtoupper($data['metode_pembayaran']) ?></td></tr>

      <!-- ── Status Pesanan ── -->
      <tr>
        <th>Status Pesanan</th>
        <td>
          <span class="status <?= badgeClass($data['status']) ?>">
            <?= ucfirst($data['status']) ?>
          </span>
        </td>
      </tr>

      <!-- ── Status Pembayaran ── -->
      <tr>
        <th>Status Pembayaran</th>
        <td>
          <span class="status <?= badgeClass($data['status_pembayaran']) ?>">
            <?= ucfirst($data['status_pembayaran']) ?>
          </span>
        </td>
      </tr>

      <tr><th>Tanggal Pembayaran</th>
          <td><?= $data['tanggal_bayar'] ? date('d F Y H:i',strtotime($data['tanggal_bayar'])) : 'Belum dibayar' ?></td></tr>

      <tr><th>Bukti Pembayaran</th>
        <td>
          <?php if ($data['metode_pembayaran']!='cod' && $data['bukti'] && $data['bukti']!=='-'): ?>
            <div class="bukti-container">
              <img src="../bukti/<?= $data['bukti'] ?>" alt="Bukti Pembayaran">
            </div>
          <?php else: ?><em>Tidak Ada (COD)</em><?php endif; ?>
        </td>
      </tr>
    </table>
    <?php if ($data['status_pembayaran'] === 'menunggu konfirmasi'): ?>
  <div style="margin-top: 20px; display: flex; gap: 10px;">
    <form action="ubah_status_pembayaran.php" method="post" onsubmit="return confirm('Setujui pembayaran ini sebagai LUNAS?')">
      <input type="hidden" name="id" value="<?= $data['id_pembayaran'] ?>">
      <input type="hidden" name="status" value="lunas">
      <button type="submit" class="btn">Setujui (Lunas)</button>
    </form>

    <form action="ubah_status_pembayaran.php" method="post" onsubmit="return confirm('Tolak pembayaran ini?')">
      <input type="hidden" name="id" value="<?= $data['id_pembayaran'] ?>">
      <input type="hidden" name="status" value="ditolak">
      <button type="submit" class="btn" style="background:#e74a3b">Tolak</button>
    </form>
  </div>
<?php endif; ?>

  </div>

</div>
</body>
</html>
