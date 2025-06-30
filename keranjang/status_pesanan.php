<?php
session_set_cookie_params(['path' => '/']);
date_default_timezone_set('Asia/Jakarta');
session_start();
include '../home/koneksi.php';

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id'];

$query = "SELECT 
    transaksi.id_transaksi, transaksi.tanggal_transaksi, transaksi.total_harga, transaksi.status, transaksi.ongkir,
    pembayaran.metode_pembayaran, pembayaran.tanggal_bayar,
    barang.nama_barang, barang.gambar, detail_transaksi.jumlah, detail_transaksi.ukuran
    FROM transaksi
    LEFT JOIN pembayaran ON transaksi.id_transaksi = pembayaran.id_transaksi
    LEFT JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
    LEFT JOIN barang ON detail_transaksi.id_barang = barang.id_barang
    WHERE transaksi.id_user = $id_user
    ORDER BY transaksi.id_transaksi DESC";


$result = mysqli_query($koneksi, $query);

$transaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_transaksi'];
    if (!isset($transaksi[$id])) {
 $transaksi[$id] = [
    'tanggal' => $row['tanggal_transaksi'],
    'total' => $row['total_harga'],
    'ongkir' => $row['ongkir'],
    'status' => $row['status'],
    'metode' => $row['metode_pembayaran'],
    'tanggal_bayar' => $row['tanggal_bayar'],
    'items' => []
];

    }

    $transaksi[$id]['items'][] = [
        'nama' => $row['nama_barang'],
        'gambar' => $row['gambar'],
        'jumlah' => $row['jumlah'],
        'ukuran' => $row['ukuran']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - Twinkle Toes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-selesai {
            background-color: #DCFCE7;
            color: #166534;
        }
        .status-dikirim {
            background-color: #FEF9C3;
            color: #854D0E;
        }
        .status-menunggu {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        .status-ditolak {
            background-color: #FECACA;
            color: #991B1B;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto p-4 md:p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>
                Status Pesanan
            </h1>
            <a href="../home/home.php" class="text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="space-y-4">
            <?php if (empty($transaksi)) : ?>
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <i class="fas fa-shopping-bag text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 mb-4">Anda belum memiliki pesanan</p>
                    <a href="../home/home.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Mulai Belanja
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($transaksi as $id => $data) : ?>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                        <!-- Header -->
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex flex-wrap justify-between items-center gap-2">
                                <div>
                                    <span class="text-sm text-gray-500">No. Pesanan:</span>
                                    <span class="font-medium text-gray-800">#<?= $id ?></span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Tanggal:</span>
                                    <span class="font-medium text-gray-800">
                                        <?= date('d M Y, H:i', strtotime($data['tanggal_bayar'] ?? $data['tanggal'])) ?>
                                    </span>
                                </div>
                                <div>
                                    <?php
                                    $status = strtolower($data['status']);
                                    $statusClass = match ($status) {
                                        'selesai' => 'status-selesai',
                                        'dalam pengiriman' => 'status-dikirim',
                                        'ditolak' => 'status-ditolak',
                                        default => 'status-menunggu'
                                    };
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <?= ucfirst($data['status']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="p-4 space-y-4">
                            <?php foreach ($data['items'] as $item) : ?>
                                <div class="flex items-start gap-4">
                                    <img src="../home/upload/<?= $item['gambar'] ?>" 
                                         alt="<?= $item['nama'] ?>" 
                                         class="w-16 h-16 object-cover rounded-md border border-gray-200">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800"><?= $item['nama'] ?></h3>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <span>Ukuran: <?= $item['ukuran'] ?></span>
                                            <span class="mx-2">•</span>
                                            <span>Qty: <?= $item['jumlah'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
<!-- Footer -->
<div class="p-4 border-t border-gray-200 bg-gray-50">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div class="text-sm">
            <span class="text-gray-500">Metode Pembayaran:</span>
            <span class="font-medium text-gray-800 ml-1">
                <?= $data['metode'] ? ucfirst($data['metode']) : '-' ?>
            </span>
            <?php if (!empty($data['tanggal_bayar'])) : ?>
                <span class="text-gray-500 ml-3">
                    (<?= date('Y-m-d H:i:s', strtotime($data['tanggal_bayar'])) ?>)
                </span>
            <?php endif; ?>
        </div>
        <div class="text-right text-sm text-gray-600">
            <div>Subtotal: Rp<?= number_format($data['total_harga'], 0, ',', '.') ?></div>
            <div>Ongkir: Rp<?= number_format($data['ongkir'], 0, ',', '.') ?></div>
            <div class="text-blue-700 font-bold">
                Total Bayar: Rp<?= number_format($data['total_harga'] + $data['ongkir'], 0, ',', '.') ?>
            </div>
        </div>
    </div>
</div>

                        <!-- Pesan Penolakan -->
                        <?php if ($status === 'ditolak') : ?>
                            <div class="p-4 text-sm text-red-700 bg-red-50 border-t border-red-200">
                                Pesanan ini telah <strong>ditolak oleh admin</strong>. Silakan hubungi layanan pelanggan jika Anda merasa ada kesalahan.
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
