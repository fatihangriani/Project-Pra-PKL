<?php 
session_start();
include 'koneksi.php';
include '../navbar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Twinkle Toes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: #f9fafb;
    }
    .logo-font {
      font-family: 'Great Vibes', cursive;
    }
    .gradient-bg {
      background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    }
    .card-shadow {
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .input-focus {
      transition: all 0.3s ease;
    }
    .input-focus:focus {
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
      border-color: #3b82f6;
    }
  </style>
</head>
<body class="gradient-bg text-gray-800">

  <!-- Konten Utama -->
  <main class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row lg:space-x-12 bg-white rounded-xl overflow-hidden card-shadow">
      <!-- Bagian Kiri: Form Login -->
      <section class="lg:w-1/2 p-8 md:p-12">
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
          <p class="text-gray-600">Masuk untuk mengakses akun Anda</p>
        </div>

        <form action="proses_login.php" method="post" class="space-y-6">
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-1" for="username">Username</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-user text-gray-400"></i>
              </div>
              <input class="input-focus w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none" 
                     type="text" name="username" id="username" autocomplete="off" placeholder="Masukkan username Anda" />
            </div>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-1" for="email">Email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-gray-400"></i>
              </div>
              <input class="input-focus w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none" 
                     type="email" name="email" id="email" required placeholder="email@anda.com" autocomplete="username" />
            </div>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-1" for="password">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-gray-400"></i>
              </div>
              <input class="input-focus w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none" 
                     type="password" name="password" id="password" required placeholder="••••••••" autocomplete="current-password"/>
            </div>
          </div>
          
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="remember-me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
            </div>
          </div>
          
          <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200">
            Masuk
          </button>
        </form>
        
        <div class="mt-6 text-center">
          <p class="text-gray-600">Belum punya akun? 
            <a href="daftar.php" class="font-medium text-blue-600 hover:text-blue-500 transition">Daftar disini</a>
          </p>
        </div>
        
        <div class="mt-8">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
        </div>
      </section>
      
      <!-- Bagian Kanan: Info Pendaftaran -->
      <section class="lg:w-1/2 bg-gradient-to-br from-blue-50 to-indigo-50 p-8 md:p-12 flex flex-col justify-center">
        <div>
          <h2 class="text-3xl font-bold text-gray-900 mb-6">Bergabunglah dengan Twinkle Toes Sekarang!</h2>
          <p class="text-gray-700 mb-6">Buat akun untuk mendapatkan keuntungan eksklusif dan pengalaman belanja yang lebih baik.</p>
          
          <ul class="space-y-4">
            <li class="flex items-start">
              <div class="flex-shrink-0 h-6 w-6 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
            </li>
            <li class="flex items-start">
              <div class="flex-shrink-0 h-6 w-6 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p class="ml-3 text-gray-700">Lacak pesanan dan status pengiriman dengan mudah</p>
            </li>
            <li class="flex items-start">
              <div class="flex-shrink-0 h-6 w-6 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p class="ml-3 text-gray-700">Simpan dan kelola produk favorit Anda</p>
            </li>
            <li class="flex items-start">
              <div class="flex-shrink-0 h-6 w-6 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p class="ml-3 text-gray-700">Proses checkout lebih cepat</p>
            </li>
            <li class="flex items-start">
              <div class="flex-shrink-0 h-6 w-6 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p class="ml-3 text-gray-700">Akses ke fitur-fitur eksklusif</p>
            </li>
          </ul>
        </div>
      </section>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white px-4 py-8 text-sm text-gray-600 leading-relaxed text-center mt-12">
    <div class="max-w-6xl mx-auto">
      <p class="max-w-3xl mx-auto">
        Selamat datang di <span class="font-semibold text-gray-800">Twinkle Toes</span>, tempat di mana gaya dan kenyamanan bertemu dalam setiap langkah. Kami menghadirkan koleksi sepatu pria, wanita, dan anak-anak dengan desain yang trendi, elegan, dan berkualitas tinggi.
      </p>
      <p class="mt-3 max-w-3xl mx-auto">
        Belanja mudah, nyaman, dan terpercaya hanya di <span class="font-semibold text-gray-800">Twinkle Toes</span>!
      </p>

      <!-- Tautan Admin -->
      <p class="mt-6 text-gray-400 text-xs">
        <a href="../app_sepatu1/login_admin.php" class="hover:text-gray-600 transition">Login Admin</a>
      </p>
    </div>
  </footer>
</body>
</html>