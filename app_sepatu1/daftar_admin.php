<?php
include '../home/koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Hitung jumlah admin
    $cek_admin = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE role='admin'");
    $jumlah = mysqli_fetch_assoc($cek_admin)['total'];

    if ($jumlah >= 2) {
        echo "<script>alert('Hanya bisa mendaftarkan maksimal 2 admin.'); window.location='admin_register.php';</script>";
        exit;
    }

    // Simpan admin
    $query = "INSERT INTO users (username, email, no_hp, alamat, password, role) 
              VALUES ('$username', '$email', '$no_hp', '$alamat', '$password', 'admin')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Admin berhasil didaftarkan!'); window.location='login_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal mendaftar admin.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --utama: #4361ee;
            --utama-gelap: #3a56d4;
            --sekunder: #3f37c9;
            --sukses: #4cc9f0;
            --bahaya: #f72585;
            --peringatan: #f8961e;
            --info: #4895ef;
            --terang: #f8f9fa;
            --gelap: #212529;
            --abu: #6c757d;
            --putih: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .register-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 480px;
            margin: 20px;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header h2 {
            color: var(--gelap);
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .register-header p {
            color: var(--abu);
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--gelap);
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            border-color: var(--utama);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
        }
        
        .submit-btn {
            width: 100%;
            background-color: var(--utama);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: var(--utama-gelap);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--abu);
        }
        
        .login-link a {
            color: var(--utama);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            right: 15px;
            top: 42px;
            color: var(--abu);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h2>Daftar Admin</h2>
            <p>Silakan isi form berikut untuk mendaftar sebagai admin</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-icon">
                    <input type="email" id="email" name="email" autocomplete="username" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="username">Nama Lengkap</label>
                <div class="input-icon">
                    <input type="text" id="username" name="username" autocomplete="off" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="no_hp">Nomor Handphone</label>
                <div class="input-icon">
                    <input type="tel" id="no_hp" name="no_hp" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <div class="input-icon">
                    <input type="text" id="alamat" name="alamat" required>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Daftar Sekarang</button>
        </form>
        
        <div class="login-link">
            Sudah punya akun? <a href="login_admin.php">Masuk disini</a>
        </div>
    </div>
</body>
</html>