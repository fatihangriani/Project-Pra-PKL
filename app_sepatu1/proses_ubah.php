<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$id       = mysqli_real_escape_string($koneksi, $_POST['id_user']);
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$email    = mysqli_real_escape_string($koneksi, $_POST['email']);
$alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$no_hp    = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

$sql = "UPDATE users SET 
          username='$username',
          email='$email',
          alamat='$alamat',
          no_hp='$no_hp'
        WHERE id_user='$id'";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: pelanggan.php?edit=sukses");
} else {
    header("Location: pelanggan.php?edit=gagal");
}
exit;
?>
