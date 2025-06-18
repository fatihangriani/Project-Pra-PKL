<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
include '../navbar.php';

// Ambil data user dari database
$id_user = $_SESSION['user']['id']; // Sesuaikan dengan struktur session Anda
$query = "SELECT * FROM users WHERE id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Twinkle Toes - Informasi Pribadi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .logo-font {
      font-family: 'Great Vibes', cursive;
    }
    .glass-effect {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .input-focus:focus {
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
      border-color: #3b82f6;
    }
  </style>
</head>
<body class="relative text-gray-800 min-h-screen">
<!-- Main Content -->
  <main class="max-w-6xl mx-auto px-4 py-10 lg:py-16 relative z-10">
    <!-- Header Section -->
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800 drop-shadow-md">INFORMASI PRIBADI</h2>
      <p class="mt-2 text-gray-600">Kelola informasi akun dan preferensi Anda</p>
    </div>

    <!-- Personal Information Form -->
    <form class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto glass-effect p-8 rounded-xl shadow-lg">
      <div class="space-y-1">
        <label for="email" class="block font-semibold text-gray-700">Email</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-envelope text-gray-400"></i>
          </div>
          <input id="email" name="email" type="email" value="<?= htmlspecialchars($user_data['email'] ?? '') ?>" 
                 class="input-focus w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none" 
                 placeholder="email@anda.com" readonly />
        </div>
      </div>
      
      <div class="space-y-1">
        <label for="nama" class="block font-semibold text-gray-700">Nama Lengkap</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-user text-gray-400"></i>
          </div>
          <input id="nama" name="nama" type="text" value="<?= htmlspecialchars($user_data['nama'] ?? '') ?>" 
                 class="input-focus w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none" 
                 placeholder="Nama lengkap Anda" />
        </div>
      </div>
      
      <div class="space-y-1">
        <label for="notelp" class="block font-semibold text-gray-700">Nomor Telepon</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-phone text-gray-400"></i>
          </div>
          <input id="notelp" name="notelp" type="tel" value="<?= htmlspecialchars($user_data['no_telp'] ?? '') ?>" 
                 class="input-focus w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none" 
                 placeholder="0812-3456-7890" />
        </div>
      </div>
    
      <div class="md:col-span-2 space-y-1">
        <label for="alamat" class="block font-semibold text-gray-700">Alamat Lengkap</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 pt-3 pointer-events-none">
            <i class="fas fa-map-marker-alt text-gray-400"></i>
          </div>
          <textarea id="alamat" name="alamat" rows="3" 
                    class="input-focus w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none" 
                    placeholder="Jl. Contoh No. 123, Kota, Kode Pos"><?= htmlspecialchars($user_data['alamat'] ?? '') ?></textarea>
        </div>
      </div>
      
      <div class="md:col-span-2 flex justify-end space-x-4 pt-4">
        <button type="reset" class="px-6 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition">
          Batalkan
        </button>
        <button type="submit" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg font-medium hover:bg-gray-700 transition shadow-md">
          Simpan Perubahan
        </button>
      </div>
    </form>

    <!-- Account Management Section -->
    <section class="max-w-4xl mx-auto mt-12 glass-effect p-8 rounded-xl shadow-lg">
      <h3 class="text-xl font-bold text-gray-800 mb-6">KELOLA AKUN</h3>
    
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 bg-gray-50 rounded-lg">
          <div>
            <h4 class="font-semibold text-gray-800">Keluar dari Akun</h4>
            <p class="text-sm text-gray-600 mt-1">Anda akan keluar dari sesi ini</p>
          </div>
          <a href="logout.php" class="inline-flex justify-center">
            <button class="px-4 py-2 bg-red-50 border border-red-200 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition">
              Keluar Sekarang
            </button>
          </a>
        </div>
      </div>
      
      <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
        <h4 class="font-semibold text-blue-800 flex items-center">
          <i class="fas fa-info-circle mr-2"></i> Informasi Penting
        </h4>
        <p class="text-sm text-blue-700 mt-2">
          Setelah keluar, akses ke detail pesanan dan fitur akun akan dihentikan hingga Anda masuk kembali.
          Sampai jumpa dan terima kasih telah berkunjung ke Twinkle Toes.
        </p>
      </div>
    </section>
  </main>

  <script>
    // Tambahkan validasi form sederhana
    document.querySelector('form').addEventListener('submit', function(e) {
      const nama = document.getElementById('nama').value.trim();
      const notelp = document.getElementById('notelp').value.trim();
      
      if (!nama) {
        alert('Silakan isi nama lengkap Anda');
        e.preventDefault();
        return;
      }
      
      if (notelp && !/^[0-9+\- ]+$/.test(notelp)) {
        alert('Nomor telepon hanya boleh berisi angka dan tanda + -');
        e.preventDefault();
        return;
      }
      
      // Tambahkan notifikasi sukses
      alert('Perubahan berhasil disimpan!');
    });
  </script>
</body>
</html>