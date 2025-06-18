<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
include '../navbar.php';

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Akun Saya - Twinkle Toes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <style>
    .font-gv {
      font-family: 'Great Vibes', cursive;
    }
    .account-card {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(5px);
    }
  </style>
</head>
<body class="relative min-h-screen bg-gray-50">
  <!-- Main Content -->
  <main class="relative z-10 max-w-2xl mx-auto px-4 py-12">
    <!-- Welcome Card -->
    <div class="account-card rounded-lg shadow-md p-8 mb-8 border border-gray-100">
      <div class="flex justify-between items-start mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Halo, <?= htmlspecialchars($user_data['nama'] ?? 'Pelanggan') ?>!
          </h1>
          <p class="text-gray-600 mt-1">Selamat datang di akun Twinkle Toes Anda</p>
        </div>
        <a href="logout.php" class="text-sm text-gray-500 hover:text-gray-700">
          <i class="fas fa-sign-out-alt mr-1"></i> Keluar
        </a>
      </div>
      
      <div class="prose text-gray-700">
        <p>
          Terima kasih telah menjadi bagian dari Twinkle Toes. Di sini Anda dapat:
        </p>
        <ul class="list-disc pl-5 space-y-1 mt-2">
          <li>Mengikuti pembaruan pesanan</li>
          <li>Mengelola informasi akun</li>
          <li>Menikmati pengalaman berbelanja yang lebih personal</li>
        </ul>
        <p class="mt-4">
          Kami selalu berupaya memberikan produk terbaik untuk Anda. Selamat berbelanja!
        </p>
      </div>
    </div>

    <!-- Action Button -->
    <div class="flex justify-center">
      <a href="informasi_pribadi.php" 
         class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
        <i class="fas fa-user-circle mr-2"></i> Informasi Pribadi
      </a>
    </div>
  </main>

  <!-- Footer Note -->
  <footer class="relative z-10 text-center text-sm text-gray-500 mt-8 pb-6">
    <p>Belanja mudah, nyaman, dan terpercaya hanya di <span class="font-gv text-blue-600">Twinkle Toes</span></p>
  </footer>
</body>
</html>