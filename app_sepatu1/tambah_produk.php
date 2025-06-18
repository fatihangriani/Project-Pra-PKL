<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Tambah Produk</title>
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

    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="password"],
    input[type="file"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
      box-sizing: border-box;
    }

    button[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 12px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <form action="proses_tambah_produk.php" method="post" enctype="multipart/form-data">
    <label for="">Nama:</label>
    <input type="text" name="nama_barang" required>

    <label for="">Harga:</label>
    <input type="number" name="harga" required>

    <label for="">Stok:</label>
    <input type="number" name="stok" required>

    <label for="">Kategori:</label>
    <select name="kategori" required>
      <option value="">-- Pilih Kategori --</option>
      <option value="pria">Pria</option>
      <option value="wanita">Wanita</option>
      <option value="anak">Anak</option>
    </select>

    <label for="">Deskripsi:</label>
    <textarea name="deskripsi" rows="4" placeholder="Masukkan deskripsi produk..." required></textarea>

    <label for="">Gambar:</label>
    <input type="file" name="gambar" required>

    <button type="submit">Simpan</button>
  </form>

</body>
</html>
