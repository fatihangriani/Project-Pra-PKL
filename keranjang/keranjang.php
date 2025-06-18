<?php
session_set_cookie_params(['path' => '/']);
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}
include '../home/koneksi.php';

// Ambil isi keranjang dari session
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja - Twinkle Toes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    :root {
      --primary:rgb(78, 77, 78);
      --primary-light:rgb(107, 107, 109);
      --primary-dark:rgb(81, 81, 82);
      --secondary: #f43f5e;
      --gray-light: #f3f4f6;
      --gray-medium: #e5e7eb;
      --gray-dark: #6b7280;
      --dark:rgb(65, 65, 65);
    }
    
    .font-twinkle {
      font-family: 'Great Vibes', cursive;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9fafb;
    }
    
    .cart-item {
      transition: all 0.3s ease;
    }
    
    .cart-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .qty-btn {
      transition: all 0.2s ease;
    }
    
    .qty-btn:hover {
      background-color: var(--primary);
      color: white;
    }
    
    .remove-btn:hover {
      color: var(--secondary);
    }
    
    .checkout-btn {
      transition: all 0.3s ease;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .checkout-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(103, 103, 104, 0.2);
    }
  </style>
</head>
<body class="min-h-screen flex flex-col">
<?php include '../navbar.php'; ?>

<main class="flex-grow container mx-auto px-4 py-8">
  <div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
      <h1 class="text-2xl font-bold text-gray-900">
        <i class="fas fa-shopping-cart mr-2"></i> Keranjang Belanja
      </h1>
      <span class="text-sm text-gray-500">
        <?= count($keranjang) ?> item
      </span>
    </div>

    <?php if (empty($keranjang)): ?>
      <!-- Empty Cart -->
      <div class="bg-white rounded-xl shadow-sm p-8 text-center">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
          <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Keranjangmu kosong</h3>
        <p class="text-gray-500 mb-6">Mulai berbelanja dan temukan produk menarik di Twinkle Toes</p>
        <a href="../home/home.php" class="inline-block px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
          <i class="fas fa-arrow-left mr-2"></i> Kembali Berbelanja
        </a>
      </div>
    <?php else: ?>
      <form action="checkout.php" method="post">
        <!-- Cart Items -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
          <?php foreach ($keranjang as $key => $item):
            $id = $item['id_barang'];
            $barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = $id"));
            $gambar = htmlspecialchars($barang['gambar']);
            $nama = htmlspecialchars($barang['nama_barang']);
            $harga = (int)$barang['harga'];
            $ukuran = $item['ukuran'];
            $qty = $item['jumlah'];
          ?>
          <div class="cart-item p-4 border-b border-gray-100 flex items-start md:items-center gap-4">
            <!-- Checkbox -->
            <input type="checkbox" 
                   name="items[]" 
                   class="pilih-item h-5 w-5 text-primary rounded border-gray-300 focus:ring-primary mt-1 md:mt-0" 
                   value="<?= $key ?>" 
                   onchange="updateTotal()" 
                   checked>

            <!-- Product Image -->
            <img src="../home/upload/<?= $gambar ?>" 
                 alt="<?= $nama ?>" 
                 class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover border border-gray-200">

            <!-- Product Info -->
            <div class="flex-1">
              <h3 class="font-medium text-gray-900 mb-1"><?= $nama ?></h3>
              <p class="text-sm text-gray-500 mb-2">Ukuran: <?= $ukuran ?></p>
              <p class="text-primary font-semibold">
                Rp <span id="harga-<?= $key ?>"><?= number_format($harga, 0, ',', '.') ?></span>
              </p>
            </div>

            <!-- Quantity Controls -->
            <div class="flex items-center gap-2">
              <button type="button" 
                      onclick="kurang('<?= $key ?>')" 
                      class="qty-btn w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:border-primary">
                <i class="fas fa-minus text-xs"></i>
              </button>
              <input type="text" 
                     id="qty-<?= $key ?>" 
                     value="<?= $qty ?>" 
                     class="w-12 text-center border-0 bg-gray-100 rounded-md py-1" 
                     readonly>
              <button type="button" 
                      onclick="tambah('<?= $key ?>')" 
                      class="qty-btn w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:border-primary">
                <i class="fas fa-plus text-xs"></i>
              </button>
            </div>

            <!-- Remove Button -->
            <button type="button" 
                    onclick="hapus('<?= $key ?>')" 
                    class="remove-btn text-gray-400 hover:text-secondary ml-4">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Summary -->
        <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">
              <span id="terpilih">0</span> item dipilih
            </h3>
            <div class="text-right">
              <p class="text-sm text-gray-500">Total Harga</p>
              <p class="text-2xl font-bold text-primary">
                Rp <span id="total">0</span>
              </p>
            </div>
          </div>

          <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
            <a href="../home/home.php" 
               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center transition">
              <i class="fas fa-arrow-left mr-2"></i> Lanjut Belanja
            </a>
            <button type="submit" 
                    class="checkout-btn px-6 py-3 text-white rounded-lg hover:shadow-md">
              <i class="fas fa-credit-card mr-2"></i> Proses Checkout
            </button>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </div>
</main>

<script>
  function updateTotal() {
    let checkboxes = document.querySelectorAll('.pilih-item:checked');
    let total = 0;
    let jumlahDipilih = checkboxes.length;

    checkboxes.forEach(function (cb) {
      let id = cb.value;
      let harga = parseInt(document.getElementById('harga-' + id).textContent.replace(/\./g, ''));
      let qty = parseInt(document.getElementById('qty-' + id).value);
      total += harga * qty;
    });

    document.getElementById('total').textContent = total.toLocaleString('id-ID');
    document.getElementById('terpilih').textContent = jumlahDipilih;
  }

  function tambah(id) {
    let qty = document.getElementById('qty-' + id);
    qty.value = parseInt(qty.value) + 1;
    updateTotal();
  }

  function kurang(id) {
    let qty = document.getElementById('qty-' + id);
    if (parseInt(qty.value) > 1) {
      qty.value = parseInt(qty.value) - 1;
      updateTotal();
    }
  }

  function hapus(id) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
      window.location.href = 'hapus_item.php?key=' + id;
    }
  }

  // Kirim data ke checkout
  function prepareCheckoutData() {
    const form = document.querySelector('form');
    const keranjang = <?= json_encode($keranjang) ?>;

    // Hapus input hidden sebelumnya
    document.querySelectorAll('input[name="checkout_items[]"]').forEach(e => e.remove());

    document.querySelectorAll('.pilih-item:checked').forEach(cb => {
      const key = cb.value;
      const item = keranjang[key];
      const jumlah = document.getElementById('qty-' + key).value;

      const data = {
        id_barang: item.id_barang,
        ukuran: item.ukuran,
        jumlah: jumlah
      };

      const hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = 'checkout_items[]';
      hidden.value = JSON.stringify(data);
      form.appendChild(hidden);
    });
  }

  document.querySelector('form').addEventListener('submit', prepareCheckoutData);
  window.addEventListener('DOMContentLoaded', updateTotal);
</script>
</body>
</html>