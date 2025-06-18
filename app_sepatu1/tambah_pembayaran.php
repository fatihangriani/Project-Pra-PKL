<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

// Ambil data transaksi yang belum memiliki pembayaran
$query_transaksi = "SELECT transaksi.id_transaksi, users.username 
                    FROM transaksi 
                    JOIN users ON transaksi.id_user = users.id_user
                    WHERE transaksi.id_transaksi NOT IN 
                          (SELECT id_transaksi FROM pembayaran)";
$hasil_transaksi = mysqli_query($koneksi, $query_transaksi);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-xl mx-auto bg-white p-8 mt-10 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Tambah Pembayaran</h2>

        <form action="proses_tambah_bayar.php" method="POST" enctype="multipart/form-data">
            
            <!-- Pilih Transaksi -->
            <div class="mb-4">
                <label for="id_transaksi" class="block font-semibold mb-1">ID Transaksi</label>
                <select name="id_transaksi" id="id_transaksi" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih Transaksi --</option>
                    <?php while ($transaksi = mysqli_fetch_assoc($hasil_transaksi)) { ?>
                        <option value="<?= $transaksi['id_transaksi'] ?>">
                            <?= $transaksi['id_transaksi'] ?> - <?= $transaksi['username'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-4">
                <label for="metode_pembayaran" class="block font-semibold mb-1">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="cash">COD</option>
                    <option value="ovo">OVO</option>
                    <option value="Dana">-DANA</option>
                </select>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="mb-4">
                <label for="bukti_pembayaran" class="block font-semibold mb-1">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="w-full p-2 border rounded" required accept="image/*">
            </div>

            <!-- Tombol -->
            <div class="mb-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="pembayaran.php" class="ml-2 text-blue-600 hover:underline">Kembali</a>
            </div>

        </form>
    </div>
</body>
</html>
