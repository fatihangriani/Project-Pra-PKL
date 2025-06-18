<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';
$id = $_GET['id_barang'];
$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Ubah Produk</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 30px;
    }

    form {
      max-width: 500px;
      margin: auto;
      background-color: #ffffff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
      box-sizing: border-box;
    }

    img {
      display: block;
      margin-bottom: 15px;
      max-width: 100%;
      border-radius: 4px;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 12px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <form action="proses_ubah_produk.php" method="post" enctype="multipart/form-data">
    <h2>Ubah Produk</h2>

    <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">

    <label>Nama:</label>
    <input type="text" name="nama_barang" value="<?= $data['nama_barang'] ?>" required>

    <label>Harga:</label>
    <input type="number" name="harga" value="<?= $data['harga'] ?>" required>

    <label>Stok:</label>
    <input type="number" name="stok" value="<?= $data['stok'] ?>" required>

    <label>Gambar Lama:</label>
    <img src="upload/<?= $data['gambar'] ?>" alt="Gambar Produk">

    <label>Ganti Gambar (opsional):</label>
    <input type="file" name="gambar">

    <button type="submit">Simpan Perubahan</button>
  </form>

</body>
</html>
