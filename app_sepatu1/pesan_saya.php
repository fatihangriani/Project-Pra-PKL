<?php
session_start();
include '../home/koneksi.php';

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id']; 

$query = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id_user = '$id_user' ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesan Saya</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #f4f4f4;
    }
    .pesan-box {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .pesan-user {
      font-weight: bold;
      color: #333;
    }
    .pesan-tanggal {
      font-size: 12px;
      color: #777;
    }
    .pesan-isi {
      margin-top: 10px;
      color: #444;
    }
    .balasan-admin {
      margin-top: 15px;
      background-color: #e6f0ff;
      padding: 10px 15px;
      border-left: 4px solid #007bff;
      border-radius: 6px;
    }
  </style>
</head>
<body>

  <h2>Pesan Saya</h2>

  <?php if (mysqli_num_rows($query) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($query)): ?>
      <div class="pesan-box">
        <div class="pesan-user">Anda menulis:</div>
        <div class="pesan-tanggal"><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></div>
        <div class="pesan-isi"><?= nl2br(htmlspecialchars($row['pesan'])) ?></div>

        <?php if (!empty($row['balasan'])): ?>
          <div class="balasan-admin">
            <strong>Balasan Admin:</strong><br>
            <?= nl2br(htmlspecialchars($row['balasan'])) ?>
          </div>
        <?php else: ?>
          <div class="balasan-admin" style="background:#f8d7da; border-left-color:#dc3545;">
            <strong>Belum dibalas oleh admin</strong>
          </div>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Belum ada pesan yang Anda kirim.</p>
  <?php endif; ?>

</body>
</html>
