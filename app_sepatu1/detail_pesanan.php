<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

if (!isset($_GET['id_transaksi'])) {
    echo "ID transaksi tidak ditemukan";
    exit;
}

$id_transaksi = $_GET['id_transaksi'];

// Ambil data utama transaksi
$query_transaksi = mysqli_query($koneksi, "
    SELECT t.id_transaksi, u.username, t.total_harga, t.status
    FROM transaksi t
    JOIN users u ON t.id_user = u.id_user
    WHERE t.id_transaksi = '$id_transaksi'
");

$data_transaksi = mysqli_fetch_assoc($query_transaksi);

// Ambil data detail transaksi
$query_detail = mysqli_query($koneksi, "
    SELECT b.nama_barang, b.merk, dt.ukuran, dt.jumlah
    FROM detail_transaksi dt
    JOIN barang b ON dt.id_barang = b.id_barang
    WHERE dt.id_transaksi = '$id_transaksi'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --utama: #4361ee;
            --utama-gelap: #3a56d4;
            --sekunder: #3f37c9;
            --sukses: #4cc9f0;
            --bahaya: #f72585;
            --peringatan: #f8961e;
            --info: #4895ef;
            --terang: #f8f9fa;
            --gelap: #212529;
            --abu: #6c757d;
            --putih: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }
        
        h2 {
            color: var(--gelap);
            font-weight: 600;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        h3 {
            color: var(--gelap);
            font-weight: 500;
            margin: 25px 0 15px;
        }
        
        .info-group {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .info-item {
            flex: 1;
            min-width: 200px;
        }
        
        .info-item strong {
            display: block;
            color: var(--abu);
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .info-item p {
            font-size: 16px;
            color: var(--gelap);
        }
        
        .status-form {
            background-color: var(--terang);
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .status-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--gelap);
        }
        
        .status-form select {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            width: 200px;
            margin-right: 10px;
        }
        
        .status-form button {
            background-color: var(--utama);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .status-form button:hover {
            background-color: var(--utama-gelap);
            transform: translateY(-2px);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 0 1px #eee;
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: var(--utama);
            color: white;
            font-weight: 500;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f1f3ff;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            background-color: var(--terang);
            color: var(--gelap);
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }
        
        .back-btn:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }
        
        .back-btn i {
            margin-right: 8px;
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-diproses {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-dikirim {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-dibatalkan {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Pesanan</h2>
        
        <div class="info-group">
            <div class="info-item">
                <strong>ID Transaksi</strong>
                <p><?= $data_transaksi['id_transaksi']; ?></p>
            </div>
            <div class="info-item">
                <strong>Nama Pelanggan</strong>
                <p><?= $data_transaksi['username']; ?></p>
            </div>
            <div class="info-item">
                <strong>Total Harga</strong>
                <p>Rp<?= number_format($data_transaksi['total_harga'], 0, ',', '.'); ?></p>
            </div>
            <div class="info-item">
                <strong>Status Saat Ini</strong>
                <p>
                    <span class="status-badge status-<?= $data_transaksi['status']; ?>">
                        <?= ucfirst($data_transaksi['status']); ?>
                    </span>
                </p>
            </div>
        </div>

        <!-- Form Ubah Status -->
        <form class="status-form" method="POST" action="ubah_status.php">
            <input type="hidden" name="id_transaksi" value="<?= $data_transaksi['id_transaksi']; ?>">
            <label for="status"><strong>Ubah Status Pesanan</strong></label>
            <div style="display: flex; align-items: center;">
                <select name="status" id="status">
                    <option value="diproses" <?= $data_transaksi['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="dikirim" <?= $data_transaksi['status'] == 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                    <option value="selesai" <?= $data_transaksi['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="dibatalkan" <?= $data_transaksi['status'] == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                </select>
                <button type="submit">Update Status</button>
            </div>
        </form>

        <h3>Barang Dipesan</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Ukuran</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query_detail)) { ?>
                <tr>
                    <td><?= $row['nama_barang']; ?></td>
                    <td><?= $row['merk']; ?></td>
                    <td><?= $row['ukuran']; ?></td>
                    <td><?= $row['jumlah']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="pesanan.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>
</body>
</html>