<?php
session_start();
include '../home/koneksi.php';

if (!isset($_GET['id_barang'])) {
  die('ID produk tidak ditemukan!');
}
$id = intval($_GET['id_barang']);

// Get product data
$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
  die('Produk tidak ditemukan!');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($produk['nama_barang']) ?> - Twinkle Toes</title>
  <meta name="description" content="<?= htmlspecialchars($produk['nama_barang']) ?> - Detail produk sepatu dari Twinkle Toes">
  
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
            'fade-in': 'fadeIn 0.5s ease-in',
            'pulse-slow': 'pulse 3s ease-in-out infinite',
          }
        }
      }
    }
  </script>
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap');
    
    .product-image {
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .product-image:hover {
      transform: scale(1.02);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .qty-btn {
      transition: all 0.2s ease;
    }
    .qty-btn:hover {
      transform: scale(1.1);
    }
    .action-btn {
      transition: all 0.3s ease;
    }
    .action-btn:hover {
      transform: translateY(-2px);
    }
  </style>
</head>
<body class="bg-gray-50 font-poppins text-gray-800">

  <?php include '../navbar.php'; ?>

  <main class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 gap-12 animate-fade-in">
    <!-- Product Image -->
    <div class="flex justify-center items-start">
      <div class="bg-white p-6 rounded-xl shadow-md">
        <img src="../home/upload/<?= htmlspecialchars($produk['gambar']) ?>" 
             alt="<?= htmlspecialchars($produk['nama_barang']) ?>" 
             class="product-image max-w-sm w-full h-auto object-contain rounded-lg">
      </div>
    </div>

    <!-- Product Details -->
    <div class="space-y-6">
      <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($produk['nama_barang']) ?></h1>
      
      <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi Produk</h2>
        <p class="text-gray-600 leading-relaxed whitespace-pre-line">
          <?= nl2br(htmlspecialchars($produk['deskripsi'])) ?>
        </p>
      </div>

      <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-md">
        <span class="text-2xl font-bold text-gray-900">
          Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
        </span>
        <span class="text-sm text-gray-500">
          Stok: <?= $produk['stok'] ?> tersedia
        </span>
      </div>

      <!-- Order Form -->
      <form action="checkout.php" method="post" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
        <input type="hidden" name="id_barang" value="<?= $produk['id_barang'] ?>">
        <input type="hidden" name="jumlah" id="jumlahHidden" value="1">

        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Pilih Ukuran:</label>
          <select name="ukuran" required 
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            <option value="">Pilih ukuran</option>
            <?php
            $sizeRange = ($produk['kategori'] == 'anak') ? range(14, 20) : range(38, 41);
            foreach ($sizeRange as $size) {
              echo "<option value='$size'>$size</option>";
            }
            ?>
          </select>
        </div>

        <div class="flex items-center space-x-4">
          <label class="block text-sm font-medium text-gray-700">Jumlah:</label>
          <div class="flex items-center space-x-2">
            <button type="button" onclick="ubahJumlah(-1)" 
                    class="qty-btn w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
              <i class="fas fa-minus text-xs"></i>
            </button>
            <input type="number" id="jumlahInput" value="1" min="1" max="<?= $produk['stok'] ?>" 
                   class="w-16 text-center border border-gray-300 rounded py-1 px-2 bg-white" readonly>
            <button type="button" onclick="ubahJumlah(1)" 
                    class="qty-btn w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
              <i class="fas fa-plus text-xs"></i>
            </button>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-4">
          <button type="submit" name="aksi" value="keranjang"
                  formaction="tambah_keranjang.php"
                  class="action-btn flex-1 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 flex items-center justify-center space-x-2">
            <i class="fas fa-shopping-cart"></i>
            <span>Tambah ke Keranjang</span>
          </button>
          
          <button type="submit" name="beli_langsung" value="1"
                  class="action-btn flex-1 bg-gray-800 text-white px-6 py-3 rounded-md hover:bg-gray-900 flex items-center justify-center space-x-2">
            <i class="fas fa-bolt"></i>
            <span>Beli Sekarang</span>
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    function ubahJumlah(delta) {
      const input = document.getElementById('jumlahInput');
      const maxStock = <?= $produk['stok'] ?>;
      let jumlah = parseInt(input.value) || 1;
      jumlah += delta;
      
      if (jumlah < 1) jumlah = 1;
      if (jumlah > maxStock) jumlah = maxStock;
      
      input.value = jumlah;
      document.getElementById('jumlahHidden').value = jumlah;
      
      // Add pulse animation
      input.classList.add("animate-pulse-slow");
      setTimeout(() => input.classList.remove("animate-pulse-slow"), 300);
    }
  </script>

</body>
</html>