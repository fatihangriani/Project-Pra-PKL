<?php
session_start();
include '../home/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND role='admin'");
    $admin = mysqli_fetch_assoc($query);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['id_user'] = $admin['id_user'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = $admin['role'];
        $_SESSION['admin'] = true;

        header("Location: dashboard.php");
        exit;


    } else {
        echo "<script>alert('Login gagal. Cek kembali username atau password Anda.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
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
            background-image: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(255, 255, 255, 0.8) 100%);
        }
        
        .login-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            margin: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--utama), var(--sekunder));
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h2 {
            color: var(--gelap);
            font-weight: 600;
            font-size: 26px;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: var(--abu);
            font-size: 14px;
        }
        
        .login-icon {
            font-size: 60px;
            color: var(--utama);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
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
            padding: 12px 15px 12px 40px;
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
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 40px;
            color: var(--abu);
        }
        
        .submit-btn {
            width: 100%;
            background: linear-gradient(90deg, var(--utama), var(--sekunder));
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--abu);
        }
        
        .register-link a {
            color: var(--utama);
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: var(--bahaya);
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-icon">
            <i class="fas fa-lock"></i>
        </div>
        
        <div class="login-header">
            <h2>Login Admin</h2>
            <p>Silakan masuk dengan akun admin Anda</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <i class="fas fa-user input-icon"></i>
                <input type="text" id="username" name="username" required placeholder="Masukkan username admin">
                <div class="error-message" id="username-error"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <i class="fas fa-key input-icon"></i>
                <input type="password" id="password" name="password" required placeholder="Masukkan password">
                <div class="error-message" id="password-error"></div>
            </div>
            
            <button type="submit" class="submit-btn">
                <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
            </button>
        </form>
        
        <div class="register-link">
            Belum punya akun? <a href="daftar_admin.php">Daftar disini!</a>
        </div>
    </div>

    <script>
        // Simple client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            let valid = true;
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (username === '') {
                document.getElementById('username-error').textContent = 'Username harus diisi';
                document.getElementById('username-error').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('username-error').style.display = 'none';
            }
            
            if (password === '') {
                document.getElementById('password-error').textContent = 'Password harus diisi';
                document.getElementById('password-error').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('password-error').style.display = 'none';
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>