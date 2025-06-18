<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

// Ambil data user dan barang untuk dropdown
$users = mysqli_query($koneksi, "SELECT id_user, username FROM users");
$barangs = mysqli_query($koneksi, "SELECT id_barang, nama_barang FROM barang");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_POST['id_user'];
    $id_barang = $_POST['id_barang'];
    $ukuran = $_POST['ukuran'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga satuan dari barang
    $barangData = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id_barang = $id_barang");
    $barang = mysqli_fetch_assoc($barangData);
    $harga_satuan = $barang['harga'];

    // Hitung total
    $total = $harga_satuan * $jumlah;

    // Tambah ke tabel transaksi
    mysqli_query($koneksi, "INSERT INTO transaksi (id_user, tanggal_transaksi, total_harga, status) 
                            VALUES ('$id_user', NOW(), '$total', 'diproses')");

    // Ambil id transaksi terakhir
    $id_transaksi = mysqli_insert_id($koneksi);

    // Tambah ke tabel detail_transaksi
    mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_barang, ukuran, jumlah, harga_satuan) 
                            VALUES ('$id_transaksi', '$id_barang', '$ukuran', '$jumlah', '$harga_satuan')");

    header("Location: pesanan.php?simpan=sukses");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pesanan</title>
   <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    padding: 30px;
  }

  form {
    max-width: 400px;
    margin: auto;
    background-color: #ffffff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }

  label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
  }

  input[type="username"],
  input[type="barang"],
  input[type="ukuran"],
  input[type="jumlah"],
  textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
  }

  input[type="submit"]:hover {
    background-color: #45a049;
  }
</style>

</head>
<body>
<div class="content">
    <h2>Tambah Pesanan</h2>
    <form method="post">
        <label for="id_user">Username:</label>
        <select name="id_user" required>
            <option value="">--Pilih--</option>
            <?php while($u = mysqli_fetch_assoc($users)) { ?>
                <option value="<?= $u['id_user'] ?>"><?= $u['username'] ?></option>
            <?php } ?>
        </select><br><br>

        <label for="id_barang">Barang:</label>
        <select name="id_barang" required>
            <option value="">--Pilih--</option>
            <?php while($b = mysqli_fetch_assoc($barangs)) { ?>
                <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Ukuran:</label>
        <input type="text" name="ukuran" required><br><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" min="1" required><br><br>

        <input type="submit" value="Simpan">
        <a href="pesanan.php">Kembali</a>
    </form>
</div>
</body>
</html>
