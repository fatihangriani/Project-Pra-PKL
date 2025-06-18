<?php
if (!isset($_SESSION)) {
    session_start();
}

?>

<!-- CDN FontAwesome dan Tailwind jika belum dimasukkan -->
<!-- Tambahkan ini di file HTML yang memakai navbar (bukan di navbar.php langsung) -->
<!-- 
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>
-->

<header class="flex items-center justify-between px-4 py-2 border-b border-gray-300">
  <div class="flex items-center space-x-6">
    <!-- LOGO -->
    <div class="text-3xl font-[Great Vibes] select-none" style="font-family: 'Great Vibes', cursive;">
      Twinkle Toes
    </div>

    <!-- NAV KATEGORI -->
    <nav class="hidden md:flex space-x-8 font-semibold text-sm">
    
    <a href="../home/home.php" class="hover:text-blue-600">Home</a>
    
    <!-- Dropdown Kategori -->

<div class="relative group">
  <button class="hover:text-blue-600 focus:outline-none">Kategori ▾</button>

  <!-- Tambahkan "group-hover:block hover:block" agar menu tetap terbuka saat mouse di dalam menu -->
  <div class="absolute left-0 mt-2 hidden group-hover:block hover:block bg-white border rounded shadow-lg z-20">
    <a href="../kategori/pria.php" class="block px-4 py-2 hover:bg-gray-100 whitespace-nowrap">Pria</a>
    <a href="../kategori/wanita.php" class="block px-4 py-2 hover:bg-gray-100 whitespace-nowrap">Wanita</a>
    <a href="../kategori/anak.php" class="block px-4 py-2 hover:bg-gray-100 whitespace-nowrap">Anak</a>
  </div>
</div>



    <a href="../home/tentang.php" class="hover:text-blue-600">Tentang</a>
    <a href="../home/kontak.php" class="hover:text-blue-600">Kontak</a>
  </div>
    </nav>
  </div>

  <!-- ICON KERANJANG DAN LOGIN/LOGOUT -->
  <div class="flex items-center space-x-4 text-xs relative">

    <!-- 🔸 KERANJANG -->

    <!-- 🔸 STATUS DAN LOGIN -->
    <a href="../keranjang/status_pesanan.php" class="select-none hover:text-blue-600">Status Pesanan</a>


    <?php if (isset($_SESSION['user'])): ?>
  <!-- Jika SUDAH LOGIN -->
      <a href="../home/profil_pelanggan.php" class="border border-gray-400 rounded px-2 py-0.5 hover:bg-gray-100">
        Halo, <?= htmlspecialchars($_SESSION['user']['username']) ?>
      </a>
      <a href="../home/logout.php" class="border border-red-400 text-red-600 rounded px-2 py-0.5 hover:bg-red-100">
        Logout
      </a>
    <?php else: ?>
      <!-- Jika BELUM LOGIN -->
      <a href="../home/login.php" class="border border-gray-400 rounded px-2 py-0.5 hover:bg-gray-100">
        Masuk
      </a>
    <?php endif; ?>
    <a href="../keranjang/keranjang.php" class="relative text-gray-700 hover:text-black">
      <i class="fas fa-shopping-cart text-lg"></i>
      <?php if (!empty($_SESSION['keranjang'])): ?>
        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-1 rounded-full">
          <?= array_sum(array_column($_SESSION['keranjang'], 'jumlah')) ?>
        </span>
      <?php endif; ?>
    </a>
    <a href="../app_sepatu1/pesan_saya.php" class="flex items-center text-gray-700 hover:text-indigo-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
         stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 0a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
    </svg>
  </a>

  </div>
</header>