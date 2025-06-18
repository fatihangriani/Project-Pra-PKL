<?php 
session_start();
include 'koneksi.php';
include '../navbar.php';

// Ambil 3 produk pria, 2 wanita, 2 anak
$pria   = mysqli_query($koneksi, "SELECT * FROM barang WHERE kategori='pria' LIMIT 3");
$wanita = mysqli_query($koneksi, "SELECT * FROM barang WHERE kategori='wanita' LIMIT 2");
$anak   = mysqli_query($koneksi, "SELECT * FROM barang WHERE kategori='anak' LIMIT 2");

// Gabungkan ke array unggulan
$unggulan = [];
while ($r = mysqli_fetch_assoc($pria))   $unggulan[] = $r;
while ($r = mysqli_fetch_assoc($wanita)) $unggulan[] = $r;
while ($r = mysqli_fetch_assoc($anak))   $unggulan[] = $r;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Twinkle Toes - Sepatu Berkualitas dengan Harga Terjangkau</title>
  <meta name="description" content="Temukan koleksi sepatu terbaik untuk pria, wanita, dan anak-anak di Twinkle Toes. Kualitas premium dengan harga terjangkau.">
  
  <!-- Preload important resources -->
  <link rel="preload" href="img/download.jpg" as="image">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'great-vibes': ['"Great Vibes"', 'cursive'],
          },
          animation: {
            'fade-in': 'fadeIn 1s ease-in-out',
            'slide-up': 'slideUp 0.8s ease-out',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            },
            slideUp: {
              '0%': { transform: 'translateY(20px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' },
            }
          }
        }
      }
    }
  </script>
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap">
  
  <style>
    /* Custom animations */
    .hover-scale {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .gradient-overlay {
      background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.7) 100%);
    }
    .category-label {
      transition: all 0.3s ease;
    }
    .category-link:hover .category-label {
      background-color: #333;
      transform: translateX(5px);
    }
  </style>
</head>
<body class="bg-white text-gray-900 font-poppins antialiased">

  <!-- Banner with improved overlay -->
  <div class="relative w-full h-64 sm:h-[32rem] my-6 overflow-hidden rounded-xl shadow-2xl animate-fade-in">
    <img src="img/download.jpg" alt="Twinkle Toes Collection" 
         class="w-full h-full object-cover object-center" 
         loading="eager" 
         decoding="async">
    <div class="absolute inset-0 gradient-overlay rounded-xl"></div>
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 space-y-4">
      <h1 class="text-white text-3xl sm:text-5xl lg:text-6xl font-bold drop-shadow-xl animate-slide-up">
        Selangkah Lebih Dekat dengan Gaya Terbaik
      </h1>
      <p class="text-gray-200 text-sm sm:text-lg max-w-2xl drop-shadow-md animate-slide-up animation-delay-100">
        Temukan sepatu favoritmu dengan kualitas premium dan desain terkini hanya di Twinkle Toes
      </p>
      <a href="#produk-terbaik"
         class="mt-4 bg-gray-800 hover:bg-gray-900 text-white font-medium px-8 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 animate-slide-up animation-delay-200">
        Jelajahi Koleksi
      </a>
    </div>
  </div>

  <!-- Categories with better hover effects -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 sm:grid-cols-3 gap-8">
    <a href="../kategori/pria.php" class="category-link group block rounded-xl overflow-hidden bg-white relative shadow-md hover-scale">
      <img src="img/pria1.webp" alt="Sepatu Pria" 
           class="w-full h-80 sm:h-96 object-cover transition duration-500 group-hover:scale-105" 
           loading="lazy">
      <div class="category-label absolute bottom-6 left-6 bg-black text-white px-5 py-2 text-sm rounded-full flex items-center">
        Pria <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </div>
    </a>
    
    <a href="../kategori/anak.php" class="category-link group block rounded-xl overflow-hidden bg-white relative shadow-md hover-scale">
      <img src="img/anak1.jpg" alt="Sepatu Anak" 
           class="w-full h-80 sm:h-96 object-cover transition duration-500 group-hover:scale-105" 
           loading="lazy">
      <div class="category-label absolute bottom-6 left-6 bg-black text-white px-5 py-2 text-sm rounded-full flex items-center">
        Anak <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </div>
    </a>
    
    <a href="../kategori/wanita.php" class="category-link group block rounded-xl overflow-hidden bg-white relative shadow-md hover-scale">
      <img src="img/wanita1.jpeg" alt="Sepatu Wanita" 
           class="w-full h-80 sm:h-96 object-cover transition duration-500 group-hover:scale-105" 
           loading="lazy">
      <div class="category-label absolute bottom-6 left-6 bg-black text-white px-5 py-2 text-sm rounded-full flex items-center">
        Wanita <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </div>
    </a>
  </section>

  <!-- Produk Terbaik Kami with decorative elements -->
  <div id="produk-terbaik" class="max-w-7xl mx-auto px-4 sm:px-6 mb-10 relative">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
      <div class="w-full border-t border-gray-200"></div>
    </div>
    <div class="relative flex justify-center">
      <span class="bg-white px-4 text-lg font-bold text-gray-900 select-none">
        PRODUK UNGGULAN
      </span>
    </div>
  </div>

  <!-- Produk Dinamis with better cards -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <!-- Baris pertama: 3 produk -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
      <?php foreach (array_slice($unggulan, 0, 3) as $p): ?>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover-scale transition-all duration-300">
          <a href="../keranjang/detail.php?id_barang=<?= $p['id_barang'] ?>" class="block">
            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
              <img src="../home/upload/<?= $p['gambar'] ?>" 
                   alt="<?= htmlspecialchars($p['nama_barang']) ?>" 
                   class="w-full h-64 object-contain p-4 transition duration-300 hover:scale-105"
                   loading="lazy">
            </div>
            <div class="p-4 text-center">
              <h3 class="text-sm font-medium text-gray-900 mb-1 truncate"><?= htmlspecialchars($p['nama_barang']) ?></h3>
              <p class="text-sm font-semibold text-gray-800">
                Rp <?= number_format($p['harga'], 0, ',', '.') ?>
              </p>
              <button class="mt-3 w-full bg-gray-900 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                Lihat Detail
              </button>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Baris kedua: 4 produk -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      <?php foreach (array_slice($unggulan, 3) as $p): ?>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover-scale transition-all duration-300">
          <a href="../keranjang/detail.php?id_barang=<?= $p['id_barang'] ?>" class="block">
            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
              <img src="../home/upload/<?= $p['gambar'] ?>" 
                   alt="<?= htmlspecialchars($p['nama_barang']) ?>" 
                   class="w-full h-56 object-contain p-4 transition duration-300 hover:scale-105"
                   loading="lazy">
            </div>
            <div class="p-4 text-center">
              <h3 class="text-sm font-medium text-gray-900 mb-1 truncate"><?= htmlspecialchars($p['nama_barang']) ?></h3>
              <p class="text-sm font-semibold text-gray-800">
                Rp <?= number_format($p['harga'], 0, ',', '.') ?>
              </p>
              <button class="mt-3 w-full bg-gray-900 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                Lihat Detail
              </button>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Enhanced Footer -->
  <footer class="bg-gray-50 border-t border-gray-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="text-center">
        <h2 class="text-lg font-great-vibes text-gray-900 mb-2">Twinkle Toes</h2>
        <p class="max-w-2xl mx-auto text-gray-600 text-sm sm:text-base">
          Selamat datang di <strong class="font-medium">Twinkle Toes</strong>, tempat di mana gaya dan kenyamanan bertemu.
        </p>
        <p class="max-w-2xl mx-auto text-gray-600 text-sm sm:text-base mt-2">
          Belanja mudah, nyaman, dan terpercaya hanya di <strong class="font-medium">Twinkle Toes</strong>!
        </p>
        
        <!-- Social Media Links -->
        <div class="mt-6 flex justify-center space-x-6">
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Facebook</span>
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Instagram</span>
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Twitter</span>
            <i class="fab fa-twitter"></i>
          </a>
        </div>
      </div>
      
      <div class="mt-8 pt-8 border-t border-gray-200 text-center text-xs text-gray-500">
        <p>&copy; <?= date('Y') ?> Twinkle Toes. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Scroll to top button -->
  <button onclick="topFunction()" id="scrollBtn" class="fixed bottom-8 right-8 bg-gray-800 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-gray-900">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script>
    // Scroll to top button
    const scrollBtn = document.getElementById("scrollBtn");
    
    window.onscroll = function() {
      if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        scrollBtn.classList.remove("opacity-0", "invisible");
        scrollBtn.classList.add("opacity-100", "visible");
      } else {
        scrollBtn.classList.remove("opacity-100", "visible");
        scrollBtn.classList.add("opacity-0", "invisible");
      }
    };
    
    function topFunction() {
      window.scrollTo({top: 0, behavior: 'smooth'});
    }
  </script>
</body>
</html>