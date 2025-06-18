<?php
session_start();
include 'koneksi.php';
include '../navbar.php';

$nama = '';
$email = '';
$no_hp = '';
$id_user = null;

if (isset($_SESSION['user'])) {
    $id_user = $_SESSION['user']['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
    $user = mysqli_fetch_assoc($query);
    $nama = $user['username'];
    $email = $user['email'];
    $no_hp = $user['no_hp'];

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pesan = isset($_POST['pesan']) ? htmlspecialchars($_POST['pesan']) : '';

    if (!$id_user) {
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $no_hp = htmlspecialchars($_POST['no_hp']);
    }

    if (empty($nama) || empty($email) || empty($no_hp) || empty($pesan)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
        exit;
    }

    $nama = mysqli_real_escape_string($koneksi, $nama);
    $email = mysqli_real_escape_string($koneksi, $email);
    $no_hp = mysqli_real_escape_string($koneksi, $no_hp);
    $pesan = mysqli_real_escape_string($koneksi, $pesan);

    $id_user_sql = isset($id_user) && is_numeric($id_user) ? $id_user : 'NULL';
    $tanggal = date('Y-m-d H:i:s');
    $sql = "INSERT INTO komentar (id_user, nama, email, no_hp, pesan, tanggal)
 VALUES (" . ($id_user_sql === 'NULL' ? "NULL" : $id_user_sql) . ", '$nama', '$email', '$no_hp', '$pesan', '$tanggal')";

    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>alert('Pesan berhasil dikirim!'); window.location='kontak.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pesan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kontak Kami - Twinkle Toes</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Hero Section -->
<div class="py-10 bg-white shadow">
  <div class="text-center">
    <h1 class="text-3xl font-bold text-gray-800">Hubungi <span class="text-gray-500">Twinkle Toes</span></h1>
    <p class="text-gray-600 mt-2">Silakan tinggalkan pesan dan kami akan merespons secepat mungkin.</p>
  </div>
</div>

<!-- Form Section -->
<div class="max-w-4xl mx-auto py-10 px-4">
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Kirim Pesan</h2>
    <form method="POST">
      <div class="grid sm:grid-cols-2 gap-4">
        <input name="nama" type="text" placeholder="Nama" value="<?= htmlspecialchars($nama) ?>" class="w-full border p-2 rounded" />
        <input name="email" type="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" class="w-full border p-2 rounded" />
        <input name="no_hp" type="text" placeholder="No HP" value="<?= htmlspecialchars($no_hp) ?>" class="w-full border p-2 rounded sm:col-span-2" />
      </div>
      <textarea name="pesan" rows="4" placeholder="Tulis pesan Anda..." class="w-full border p-2 rounded mt-4"></textarea>
      <button type="submit" class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
        Kirim Pesan
      </button>
    </form>
  </div>

  <!-- Tampilkan pesan & balasan -->
  <?php if ($id_user): ?>
  <div class="mt-10">
    <h2 class="text-xl font-semibold mb-4">Pesan Anda</h2>
    <?php
    $res = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id_user = '$id_user' ORDER BY tanggal DESC");
    if (mysqli_num_rows($res) > 0):
      while ($row = mysqli_fetch_assoc($res)):
    ?>
    <div class="bg-gray-100 p-4 rounded mb-4 border">
      <p><span class="font-medium">Pesan:</span><br><?= nl2br(htmlspecialchars($row['pesan'])) ?></p>
      <?php if (!empty($row['balasan'])): ?>
        <div class="mt-2 pl-4 border-l-4 border-blue-400">
          <p class="text-sm text-gray-600 font-medium">Balasan Admin:</p>
          <p class="italic text-blue-800"><?= nl2br(htmlspecialchars($row['balasan'])) ?></p>
        </div>
      <?php else: ?>
        <p class="text-sm text-gray-500 italic mt-2">Belum ada balasan dari admin.</p>
      <?php endif; ?>
      <p class="text-xs text-gray-400 mt-2">Tanggal: <?= $row['tanggal'] ?></p>
    </div>
    <?php endwhile; else: ?>
      <p class="text-gray-500">Anda belum mengirim pesan apapun.</p>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</div>
</body>
</html>
