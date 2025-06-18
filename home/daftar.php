<?php
include 'koneksi.php';

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Akun</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #f8f9fa, #e9ecef);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background: white;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 100%;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 14px;
    }

    input[type="submit"] {
      width: 100%;
      background-color:rgb(90, 88, 88);
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: rgb(65, 63, 63);
    }

    .note {
      font-size: 12px;
      text-align: center;
      color: #777;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Daftar Akun</h2>
    <form action="proses_daftar.php" method="post">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" autocomplete="username" required>

      <label for="username">Nama</label>
      <input type="text" id="username" name="username" autocomplete="off" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <label for="no_hp">No. Handphone</label>
      <input type="number" id="no_hp" name="no_hp" required>

      <label for="alamat">Alamat Lengkap</label>
      <input type="text" name="alamat" id="alamat">

      <input type="submit" value="Daftar">
    </form>
  </div>
</body>
</html>
