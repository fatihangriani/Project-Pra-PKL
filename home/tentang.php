<?php
include 'koneksi.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Twinkle Toes - Tentang Kami</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .logo-font {
      font-family: 'Great Vibes', cursive;
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .gradient-bg {
      background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(245,245,245,0.9) 100%);
    }
  </style>
</head>
<body class="relative text-gray-800 min-h-screen overflow-x-hidden">

  <!-- Hero Background -->
  <div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-b from-white/70 to-white/30"></div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-16 relative z-10">
    <!-- Page Header -->
    <div class="text-center mb-12">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        <span class="logo-font text-4xl md:text-5xl text-gray-600">Twinkle Toes</span><br>
        Tentang Kami
      </h1>
      <div class="w-24 h-1 bg-blue-500 mx-auto"></div>
    </div>

    <!-- About Content -->
    <div class="glass-card rounded-xl shadow-xl overflow-hidden max-w-4xl mx-auto">
      <div class="p-8 md:p-10">
        <div class="prose max-w-none">
          <p class="text-lg leading-relaxed text-gray-700 mb-6">
            <span class="font-semibold text-black-600">Twinkle Toes</span> adalah destinasi utama bagi pecinta sepatu berkualitas di Indonesia. Sejak berdiri, kami telah berkomitmen untuk menyediakan koleksi alas kaki terbaik untuk seluruh keluarga, mulai dari pria, wanita, hingga anak-anak.
          </p>

          <p class="text-lg leading-relaxed text-gray-700 mb-6">
            Kami memahami bahwa sepatu bukan sekadar pelengkap penampilan, melainkan bagian penting dari ekspresi diri dan kenyamanan sehari-hari. Setiap koleksi yang kami tawarkan dipilih dengan cermat untuk memenuhi berbagai kebutuhan dan gaya hidup.
          </p>

          <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="text-blue-800 font-medium">
              "Melalui platform belanja online yang aman dan praktis, kami berkomitmen untuk memberikan pengalaman berbelanja yang menyenangkan, dilengkapi dengan pengiriman yang terpercaya serta layanan pelanggan yang sigap."
            </p>
          </div>

          <p class="text-center text-lg font-medium text-gray-900 mt-8">
            Terima kasih telah memilih <span class="text-black-600 font-semibold">Twinkle Toes</span> untuk menemani setiap langkah Anda.
          </p>
        </div>
      </div>
    </div>

    <!-- Team Section -->
    <div class="glass-card rounded-xl shadow-xl overflow-hidden max-w-4xl mx-auto mt-12">
      <div class="p-8 md:p-10">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Tim Kami</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
              <img src="img/team1.jpg" alt="Team Member" class="w-full h-full object-cover">
            </div>
            <h3 class="font-semibold text-lg">Budi Santoso</h3>
            <p class="text-blue-600 text-sm">Founder & CEO</p>
          </div>
          <div class="text-center">
            <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
              <img src="img/team2.jpg" alt="Team Member" class="w-full h-full object-cover">
            </div>
            <h3 class="font-semibold text-lg">Ani Wijaya</h3>
            <p class="text-blue-600 text-sm">Head of Marketing</p>
          </div>
          <div class="text-center">
            <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
              <img src="img/team3.jpg" alt="Team Member" class="w-full h-full object-cover">
            </div>
            <h3 class="font-semibold text-lg">Rudi Hermawan</h3>
            <p class="text-blue-600 text-sm">Customer Service Manager</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="text-center mt-12">
      <h3 class="text-xl font-semibold text-gray-900 mb-4">Ada pertanyaan atau butuh bantuan?</h3>
      <a href="kontak.php" class="inline-block px-8 py-3 bg-gray-600 text-white font-medium rounded-lg shadow-md hover:bg-black-700 transition duration-300">
        <i class="fas fa-envelope mr-2"></i> Hubungi Kami
      </a>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white/90 py-8 mt-16 relative z-10">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p class="text-gray-700 mb-2">Belanja mudah, nyaman, dan terpercaya hanya di</p>
      <h3 class="text-2xl font-bold text-gray-600 logo-font mb-4">Twinkle Toes</h3>
      <p class="text-sm text-gray-500">&copy; <?= date('Y') ?> Twinkle Toes. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>