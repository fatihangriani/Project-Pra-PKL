<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

include '../home/koneksi.php';

// Proses tambah akun
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $role = $_POST['role'];

    // Cek apakah email atau username sudah digunakan
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username atau Email sudah digunakan!'); window.location='tambah_akun.php';</script>";
    } else {
        $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Akun berhasil ditambahkan'); window.location='akun.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan akun');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Akun</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            padding: 40px;
        }

        .form-container {
            background: #fff;
            max-width: 500px;
            margin: auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background-color: #45a049;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #4361ee;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Tambah Akun</h2>
    <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Role</label>
        <select name="role" id="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Simpan</button>
        <br>
    </form>
</div>

</body>
</html>
