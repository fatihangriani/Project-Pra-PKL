<?php
session_start();
include '../home/koneksi.php';
include '../navbar.php';

// Ambil semua produk dengan kategori 'pria'
$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE kategori='pria'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Twinkle Toes ‒ Koleksi Sepatu Pria Premium</title>
  <meta name="description" content="Temukan koleksi sepatu pria terbaik di Twinkle Toes. Gaya modern, kualitas premium untuk penampilan maksimal.">
  
  <!-- Preload important resources -->
  <link rel="preload" href="img/bg-pria.webp" as="image">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'great-vibes': ['"Great Vibes"', 'cursive'],
            'poppins': ['Poppins', 'sans-serif']
          },
          animation: {
            'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
            'fade-in': 'fadeIn 1s ease-in-out',
          },
          keyframes: {
            fadeInUp: {
              '0%': { opacity: '0', transform: 'translateY(20px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            }
          },
          colors: {
            primary: {
              50: '#f8fafc',
              100: '#f1f5f9',
              200: '#e2e8f0',
              300: '#cbd5e1',
              400: '#94a3b8',
              500: '#64748b',
              600: '#475569',
              700: '#334155',
              800: '#1e293b',
              900: '#0f172a',
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
    /* Custom animations and styles */
    .hero-gradient {
      background: linear-gradient(to bottom, rgba(15,23,42,0.7) 0%, rgba(15,23,42,0.3) 100%);
    }
    .product-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .price-tag {
      transition: all 0.3s ease;
    }
    .product-card:hover .price-tag {
      color: #1e293b;
    }
  </style>
</head>
<body class="bg-white text-gray-900 font-poppins antialiased">

<!-- Hero Banner -->
<div class="relative w-full h-64 sm:h-[32rem] overflow-hidden animate-fade-in">
  <img
    src="img/bg-pria.webp"
    alt="Koleksi Sepatu Pria Twinkle Toes"
    class="w-full h-full object-cover object-center"
    loading="eager"
  />
  <div class="absolute inset-0 hero-gradient"></div>
  
  <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 space-y-4 animate-fade-in-up">
    <h1 class="text-white text-3xl sm:text-5xl lg:text-6xl font-bold drop-shadow-xl">
      Gaya Pria Maksimal dengan Sepatu Terbaik
    </h1>
    <p class="text-gray-200 text-sm sm:text-lg max-w-2xl drop-shadow-md">
      Temukan sepatu pria stylish dan nyaman yang cocok buat aktivitas dan gaya harianmu
    </p>
    <a href="#sepatu-pria" class="mt-6 inline-block bg-gray-800 hover:bg-gray-900 text-white font-medium px-8 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
      Jelajahi Koleksi
    </a>
  </div>
</div>

<!-- Category Title with Decorative Elements -->
<div id="sepatu-pria" class="max-w-7xl mx-auto px-4 sm:px-6 my-12 relative">
  <div class="absolute inset-0 flex items-center" aria-hidden="true">
    <div class="w-full border-t border-gray-200"></div>
  </div>
  <div class="relative flex justify-center">
    <span class="bg-white px-4 text-xl font-bold text-gray-900 uppercase tracking-wider">
      Koleksi Sepatu Pria
    </span>
  </div>
</div>

<!-- Product Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    <?php while($p = mysqli_fetch_assoc($query)): ?>
      <div class="product-card bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
        <a href="../keranjang/detail.php?id_barang=<?= $p['id_barang'] ?>" class="block group">
          <div class="relative overflow-hidden">
            <img 
              src="../home/upload/<?= htmlspecialchars($p['gambar']) ?>" 
              alt="<?= htmlspecialchars($p['nama_barang']) ?>" 
              class="w-full h-64 object-contain p-4 transition duration-500 group-hover:scale-105"
              loading="lazy"
            >
            <!-- Badge for new arrivals or discounts could be added here -->
          </div>
          <div class="p-4 text-center">
            <h3 class="text-sm font-medium text-gray-900 mb-1 truncate"><?= htmlspecialchars($p['nama_barang']) ?></h3>
            <div class="price-tag text-sm font-semibold text-gray-600 mb-3">
              Rp <?= number_format($p['harga'], 0, ',', '.') ?>
            </div>
            <button class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-900 transition">
              Lihat Detail
            </button>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Enhanced Footer -->
<footer class="bg-gray-50 border-t border-gray-200 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="text-center">
      <h2 class="text-2xl font-great-vibes text-gray-900 mb-2">Twinkle Toes</h2>
      <p class="max-w-2xl mx-auto text-gray-600 text-sm sm:text-base">
        Sepatu Pria Berkualitas. Memberikan kenyamanan dan gaya untuk setiap langkah Anda.
      </p>
      
      <!-- Social Media Links -->
      <div class="mt-6 flex justify-center space-x-6">
        <a href="#" class="text-gray-400 hover:text-gray-600 transition">
          <span class="sr-only">Facebook</span>
          <i class="fab fa-facebook-f text-lg"></i>
        </a>
        <a href="#" class="text-gray-400 hover:text-gray-600 transition">
          <span class="sr-only">Instagram</span>
          <i class="fab fa-instagram text-lg"></i>
        </a>
        <a href="#" class="text-gray-400 hover:text-gray-600 transition">
          <span class="sr-only">WhatsApp</span>
          <i class="fab fa-whatsapp text-lg"></i>
        </a>
      </div>
    </div>
    
    <div class="mt-8 pt-8 border-t border-gray-200 text-center text-xs text-gray-500">
      <p>&copy; <?= date('Y') ?> Twinkle Toes. All rights reserved.</p>
    </div>
  </div>
</footer>

<!-- Scroll to top button -->
<button onclick="topFunction()" id="scrollBtn" class="fixed bottom-8 right-8 bg-gray-800 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-gray-900">
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