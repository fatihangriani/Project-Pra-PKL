<?php
session_set_cookie_params(['path' => '/']);
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}

include '../home/koneksi.php';
$id_user = $_SESSION['user']['id'];

$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = $id_user");
$data_user = mysqli_fetch_assoc($query_user);

$username = $data_user['username'] ?? '';
$no_hp  = $data_user['no_hp'] ?? '';
$email  = $data_user['email'] ?? '';
$alamat = $data_user['alamat'] ?? '';

$checkout_items = $_POST['checkout_items'] ?? [];
$barang_checkout = [];
$total_harga = 0;

// 🔸 Jika datang dari tombol "Beli Sekarang"
if (isset($_POST['beli_langsung'])) {
    $id_barang = $_POST['id_barang'] ?? null;
    $ukuran = $_POST['ukuran'] ?? null;
    $jumlah = $_POST['jumlah'] ?? 1;

    if ($id_barang && $ukuran && $jumlah > 0) {
        $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = " . intval($id_barang));
        if ($data = mysqli_fetch_assoc($query)) {
            $data['jumlah'] = intval($jumlah);
            $data['ukuran'] = htmlspecialchars($ukuran);
            $barang_checkout[] = $data;
            $total_harga += $data['harga'] * $jumlah;
        }
    } else {
        echo "<script>alert('Data tidak valid untuk beli langsung.'); window.location='keranjang.php';</script>";
        exit;
    }
}

// 🔸 Jika checkout dari keranjang
foreach ($checkout_items as $json) {
    $item = json_decode($json, true); 

    if (!isset($item['id_barang'], $item['jumlah'], $item['ukuran'])) {
        continue;
    }

    $id_barang = intval($item['id_barang']);
    $jumlah = intval($item['jumlah']);
    $ukuran = htmlspecialchars($item['ukuran']);

    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = $id_barang");
    if ($data = mysqli_fetch_assoc($query)) {
        $data['jumlah'] = $jumlah;
        $data['ukuran'] = $ukuran;
        $barang_checkout[] = $data;
        $total_harga += $data['harga'] * $jumlah;
    }
}

$ongkir = 10000;
$total_bayar = $total_harga + $ongkir;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Twinkle Toes</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    :root {
      --primary:rgb(84, 83, 85);
      --primary-light:rgb(66, 66, 66);
      --primary-dark:rgb(93, 92, 94);
      --accent: #f59e0b;
      --success: #10b981;
      --danger: #ef4444;
      --light: #f8fafc;
      --light-gray: #f1f5f9;
      --gray: #94a3b8;
      --dark-gray: #64748b;
      --dark: #1e293b;
      --white: #ffffff;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --rounded-sm: 0.25rem;
      --rounded: 0.5rem;
      --rounded-lg: 0.75rem;
      --rounded-xl: 1rem;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--light-gray);
      color: var(--dark);
      line-height: 1.6;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }
    
    /* Header */
    .checkout-header {
      text-align: center;
      margin-bottom: 3rem;
      position: relative;
    }
    
    .checkout-title {
      font-size: 2.25rem;
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 0.5rem;
      position: relative;
      display: inline-block;
    }
    
    .checkout-title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(to right, var(--primary), var(--accent));
      border-radius: 2px;
    }
    
    .checkout-subtitle {
      color: var(--dark-gray);
      font-weight: 400;
      max-width: 600px;
      margin: 0 auto;
    }
    
    /* Grid Layout */
    .checkout-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr;
      gap: 2rem;
    }
    
    @media (max-width: 768px) {
      .checkout-grid {
        grid-template-columns: 1fr;
      }
    }
    
    /* Card Styles */
    .checkout-card {
      background: var(--white);
      border-radius: var(--rounded-xl);
      box-shadow: var(--shadow);
      padding: 2rem;
      margin-bottom: 1.5rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .checkout-card:hover {
      box-shadow: var(--shadow-md);
      transform: translateY(-2px);
    }
    
    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--primary-dark);
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
    }
    
    .section-title i {
      margin-right: 0.75rem;
      color: var(--primary);
    }
    
    /* Form Elements */
    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }
    
    .form-label {
      display: block;
      font-size: 0.875rem;
      font-weight: 500;
      margin-bottom: 0.5rem;
      color: var(--dark-gray);
    }
    
    .form-control {
      width: 100%;
      padding: 0.875rem 1rem;
      font-size: 0.9375rem;
      border: 1px solid var(--light-gray);
      border-radius: var(--rounded);
      transition: all 0.3s ease;
      background-color: var(--white);
      color: var(--dark);
    }
    
    .form-control:focus {
      outline: none;
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    
    textarea.form-control {
      min-height: 100px;
      resize: vertical;
    }
    
    select.form-control {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236d28d9' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 16px 12px;
    }
    
    /* Product Items */
    .product-item {
      display: flex;
      align-items: center;
      padding: 1.25rem 0;
      border-bottom: 1px solid var(--light-gray);
    }
    
    .product-item:last-child {
      border-bottom: none;
    }
    
    .product-image {
      width: 80px;
      height: 80px;
      border-radius: var(--rounded);
      object-fit: cover;
      margin-right: 1.25rem;
      border: 1px solid var(--light-gray);
      transition: transform 0.3s ease;
    }
    
    .product-image:hover {
      transform: scale(1.05);
    }
    
    .product-details {
      flex: 1;
    }
    
    .product-name {
      font-weight: 600;
      margin-bottom: 0.25rem;
      color: var(--dark);
    }
    
    .product-meta {
      font-size: 0.8125rem;
      color: var(--gray);
      margin-bottom: 0.25rem;
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
    }
    
    .product-meta span {
      display: flex;
      align-items: center;
    }
    
    .product-meta i {
      margin-right: 0.25rem;
      font-size: 0.75rem;
    }
    
    .product-price {
      font-weight: 700;
      color: var(--primary-dark);
      font-size: 1rem;
    }
    
    /* Summary Section */
    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.75rem;
      font-size: 0.9375rem;
    }
    
    .summary-total {
      font-weight: 700;
      font-size: 1.125rem;
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 1px dashed var(--gray);
      color: var(--primary-dark);
    }
    
    /* Buttons */
    .btn-checkout {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(to right, var(--primary), var(--primary-light));
      color: var(--white);
      border: none;
      border-radius: var(--rounded);
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      box-shadow: var(--shadow);
    }
    
    .btn-checkout:hover {
      background: linear-gradient(to right, var(--primary-dark), var(--primary));
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }
    
    .btn-checkout i {
      margin-right: 0.75rem;
    }
    
    /* Payment Methods */
    .payment-method {
      margin-top: 1.5rem;
    }
    
    .payment-option {
      display: flex;
      align-items: center;
      padding: 1rem;
      border: 1px solid var(--light-gray);
      border-radius: var(--rounded);
      margin-bottom: 0.75rem;
      cursor: pointer;
      transition: all 0.3s ease;
      background: var(--light-gray);
    }
    
    .payment-option:hover {
      border-color: var(--primary-light);
      background: var(--white);
      box-shadow: var(--shadow-sm);
    }
    
    .payment-option input {
      margin-right: 0.75rem;
      accent-color: var(--primary);
    }
    
    .payment-icon {
      width: 30px;
      height: 30px;
      object-fit: contain;
      margin-right: 0.75rem;
      border-radius: 50%;
      padding: 0.25rem;
      background: var(--white);
      box-shadow: var(--shadow-sm);
    }
    
    .payment-label {
      font-weight: 500;
      color: var(--dark);
    }
    
    /* Alert */
    .alert {
      padding: 1rem;
      border-radius: var(--rounded);
      margin-bottom: 1.5rem;
      font-size: 0.875rem;
      background: rgba(109, 40, 217, 0.1);
      border-left: 4px solid var(--primary);
      color: var(--primary-dark);
      display: flex;
      align-items: center;
    }
    
    .alert i {
      margin-right: 0.75rem;
      font-size: 1.25rem;
    }
    
    /* Policy List */
    .policy-list {
      list-style: none;
    }
    
    .policy-item {
      margin-bottom: 0.75rem;
      display: flex;
      align-items: flex-start;
      font-size: 0.875rem;
    }
    
    .policy-item i {
      color: var(--success);
      margin-right: 0.75rem;
      margin-top: 2px;
      font-size: 1rem;
    }
    
    /* Utility Classes */
    .hidden {
      display: none;
    }
    
    .divider {
      height: 1px;
      background: var(--light-gray);
      margin: 1.5rem 0;
    }
    
    .text-muted {
      color: var(--gray);
      font-size: 0.875rem;
    }
    
    /* Progress Steps */
    .progress-steps {
      display: flex;
      justify-content: space-between;
      margin-bottom: 3rem;
      position: relative;
    }
    
    .progress-steps::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 2px;
      background: var(--light-gray);
      z-index: 1;
    }
    
    .step {
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      z-index: 2;
    }
    
    .step-number {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--light-gray);
      color: var(--gray);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      margin-bottom: 0.5rem;
      border: 3px solid var(--white);
    }
    
    .step.active .step-number {
      background: var(--primary);
      color: var(--white);
    }
    
    .step.completed .step-number {
      background: var(--success);
      color: var(--white);
    }
    
    .step-text {
      font-size: 0.75rem;
      color: var(--gray);
      font-weight: 500;
      text-align: center;
    }
    
    .step.active .step-text {
      color: var(--primary-dark);
      font-weight: 600;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .container {
        padding: 1.5rem 1rem;
      }
      
      .checkout-title {
        font-size: 1.75rem;
      }
      
      .checkout-card {
        padding: 1.5rem;
      }
      
      .progress-steps {
        margin-bottom: 2rem;
      }
    }
    
    @media (max-width: 576px) {
      .checkout-title {
        font-size: 1.5rem;
      }
      
      .product-item {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .product-image {
        margin-right: 0;
        margin-bottom: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="checkout-header">
      <h1 class="checkout-title">Checkout Pesanan</h1>
      <p class="checkout-subtitle">Lengkapi informasi berikut untuk menyelesaikan pembelian Anda</p>
    </div>
    
    <form action="checkout_proses.php" method="post" enctype="multipart/form-data">
      <div class="checkout-grid">
        <!-- Kolom Kiri - Informasi Pelanggan -->
        <div class="left-column">
          <div class="checkout-card">
            <h2 class="section-title"><i class="fas fa-user-circle"></i> Informasi Pembeli</h2>
            
            <div class="alert">
              <i class="fas fa-info-circle"></i> Pastikan informasi Anda valid untuk proses pengiriman
            </div>
            
            <div class="form-group">
              <label class="form-label">Nama Lengkap *</label>
              <input name="username" type="text" class="form-control" placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($username) ?>" required>
            </div>
        
            <div class="form-group">
              <label class="form-label">Nomor Telepon *</label>
              <input name="no_hp" type="tel" class="form-control" placeholder="Contoh: 081234567890" value="<?= htmlspecialchars($no_hp) ?>" required>
            </div>
            
            <div class="form-group">
              <label class="form-label">Alamat Email *</label>
              <input name="email" type="email" class="form-control" placeholder="Contoh: email@example.com" value="<?= htmlspecialchars($email) ?>" required>
            </div>
          </div>
      
          <div class="checkout-card">
            <h2 class="section-title"><i class="fas fa-truck"></i> Alamat Pengiriman</h2>
            
            <div class="form-group">
              <label class="form-label">Alamat Lengkap *</label>
              <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap beserta kode pos" required><?= htmlspecialchars($alamat) ?></textarea>
            </div>
            
            <div class="form-group">
              <label class="form-label">Jasa Pengiriman *</label>
              <select name="jasa_pengiriman" class="form-control" required>
                <option value="">-- Pilih Pengiriman --</option>
                <option value="JNE">JNE</option>
                <option value="J&T">J&T</option>
                <option value="SiCepat">SiCepat</option>
              </select>
            </div>
          </div>
          
          <div class="checkout-card">
            <h2 class="section-title"><i class="fas fa-credit-card"></i> Metode Pembayaran</h2>
            
            <div class="payment-option">
              <input type="radio" id="OVO" name="metode" value="OVO" checked>
              <img src="img/ovo.jpg" alt="OVO" class="payment-icon">
              <span class="payment-label">OVO</span>
            </div>
            
            <div class="payment-option">
              <input type="radio" id="DANA" name="metode" value="DANA">
              <img src="img/dana.webp" alt="DANA" class="payment-icon">
              <span class="payment-label">DANA</span>
            </div>
            
            <div id="bukti-wrapper">
              <div class="form-group" style="margin-top: 1.5rem;">
                <label class="form-label">Upload Bukti Pembayaran *</label>
                <input type="file" name="bukti" class="form-control" accept="image/*" required>
                <small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Kolom Kanan - Ringkasan Pesanan -->
        <div class="right-column">
          <div class="checkout-card">
            <h2 class="section-title"><i class="fas fa-shopping-bag"></i> Ringkasan Pesanan</h2>
            
            <?php foreach ($barang_checkout as $barang): ?>
              <div class="product-item">
                <img src="../home/upload/<?= $barang['gambar'] ?>" alt="<?= $barang['nama_barang'] ?>" class="product-image">
                <div class="product-details">
                  <div class="product-name"><?= $barang['nama_barang'] ?></div>
                  <div class="product-meta">
                    <span><i class="fas fa-ruler-combined"></i> Ukuran: <?= $barang['ukuran'] ?></span>
                    <span><i class="fas fa-layer-group"></i> Jumlah: <?= $barang['jumlah'] ?></span>
                  </div>
                  <div class="product-price">
                    Rp<?= number_format($barang['harga'] * $barang['jumlah'], 0, ',', '.') ?>
                  </div>
                </div>
                <input type="hidden" name="checkout_items[]" value='<?= json_encode([
                  'id_barang' => $barang['id_barang'],
                  'jumlah' => $barang['jumlah'],
                  'ukuran' => $barang['ukuran']
                ]) ?>'>
              </div>
            <?php endforeach; ?>
            
            <div class="divider"></div>
            
            <div class="summary-item">
              <span>Subtotal Produk</span>
              <span>Rp<?= number_format($total_harga, 0, ',', '.') ?></span>
            </div>
            <div class="summary-item">
              <span>Ongkos Kirim</span>
              <span id="ongkir_text">Rp<?= number_format($ongkir, 0, ',', '.') ?></span>
              <input type="hidden" name="ongkir" id="ongkir_value" value="<?= $ongkir ?>">
            </div>
            
            <div class="summary-item summary-total">
              <span>Total Pembayaran</span>
              <span>Rp<?= number_format($total_bayar, 0, ',', '.') ?></span>
            </div>
            
            <button type="submit" class="btn-checkout">
              <i class="fas fa-paper-plane"></i> Konfirmasi Pesanan
            </button>
          </div>
          
          <div class="checkout-card">
            <h2 class="section-title"><i class="fas fa-shield-alt"></i> Kebijakan Toko</h2>
            <ul class="policy-list">
              <li class="policy-item">
                <i class="fas fa-check-circle"></i>
                <span>Pengiriman 1-3 hari kerja setelah pembayaran dikonfirmasi</span>
              </li>
              <li class="policy-item">
                <i class="fas fa-check-circle"></i>
                <span>Garansi 7 hari pengembalian untuk produk cacat</span>
              </li>
              <li class="policy-item">
                <i class="fas fa-check-circle"></i>
                <span>Pembayaran aman melalui sistem terenkripsi</span>
              </li>
              <li class="policy-item">
                <i class="fas fa-check-circle"></i>
                <span>Layanan pelanggan 24/7 siap membantu</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // === BAGIAN ONGKIR ===
      const jasaSelect = document.querySelector('select[name="jasa_pengiriman"]');
      if (jasaSelect) {
          jasaSelect.addEventListener('change', updateOngkir);
      }

      // Fungsi untuk update ongkir dan total
      function updateOngkir() {
          const jasa = jasaSelect.value;
          let ongkir = 0;

          switch (jasa) {
              case 'JNE':
                  ongkir = 20000;
                  break;
              case 'J&T':
                  ongkir = 15000;
                  break;
              case 'SiCepat':
                  ongkir = 18000;
                  break;
              default:
                  ongkir = 0;
          }

          // Update tampilan ongkir
          document.getElementById('ongkir_text').innerText = 'Rp' + ongkir.toLocaleString('id-ID');
          document.getElementById('ongkir_value').value = ongkir;

          // Hitung total baru
          const subtotal = <?= $total_harga ?>;
          const totalBayar = subtotal + ongkir;

          // Update tampilan total
          document.querySelector('.summary-total span:last-child').innerText = 'Rp' + totalBayar.toLocaleString('id-ID');
      }

      // Panggil pertama kali untuk set nilai default
      updateOngkir();

      // === BAGIAN METODE PEMBAYARAN ===
      const pembayaranRadios = document.querySelectorAll('input[name="metode"]');
      const buktiWrapper = document.getElementById('bukti-wrapper');
      const buktiInput = buktiWrapper.querySelector('input[name="bukti"]');

      function toggleBuktiPembayaran() {
          const selectedMethod = document.querySelector('input[name="metode"]:checked').value;
          const isTransfer = selectedMethod === 'OVO' || selectedMethod === 'DANA';
          
          if (isTransfer) {
              buktiWrapper.style.display = 'block';
              buktiInput.setAttribute('required', 'required');
          } else {
              buktiWrapper.style.display = 'none';
              buktiInput.removeAttribute('required');
          }
      }

      // Tambahkan event listener untuk setiap radio button
      pembayaranRadios.forEach(radio => {
          radio.addEventListener('change', toggleBuktiPembayaran);
      });

      // Panggil pertama kali untuk set kondisi awal
      toggleBuktiPembayaran();
    });
  </script>
</body>
</html>