
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
  <title>Form Tambah Pelanggan</title>
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
  <form action="proses_tambah_pelanggan.php" method="post">
    <label for="username">username:</label>
    <input type="text" name="username" id="username" required>
    <label for="email">Masukkan Email:</label>
  <input type="text" id="email" name="email" placeholder="nama@email.com" required>
    <label for="username">Password:</label>
    <input type="password" name="password" id="password">
    
    <label for="alamat">Alamat:</label>
    <textarea name="alamat" id="alamat" rows="4" required></textarea>
     <label for="no_hp">No HP:</label>
    <input type="number" name="no_hp" id="no_hp" required>
    <input type="submit" value="Simpan!">
  </form>
</body>
</html>
