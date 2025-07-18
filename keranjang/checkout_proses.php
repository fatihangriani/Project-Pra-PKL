<?php
session_set_cookie_params(['path' => '/']);
date_default_timezone_set('Asia/Jakarta');
session_start();
include '../home/koneksi.php';

// Cek login
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id'];

// Ambil data dari form
$alamat = trim($_POST['alamat'] ?? '');
$metode = strtolower($_POST['metode'] ?? '');
$jasa_pengiriman = $_POST['jasa_pengiriman'] ?? '';
$checkout_items_raw = $_POST['checkout_items'] ?? [];
$ongkir_input = intval($_POST['ongkir'] ?? 0);

// Validasi dasar
if (empty($alamat)) die("❌ Alamat pengiriman tidak boleh kosong.");
if (!in_array($metode, ['cod', 'ovo', 'dana'])) die("❌ Metode pembayaran tidak valid.");
if (empty($jasa_pengiriman)) die("❌ Jasa pengiriman harus dipilih.");

// Validasi ongkir berdasarkan jasa pengiriman
$ongkirMap = [
    'JNE' => 20000,
    'J&T' => 15000,
    'SiCepat' => 18000
];
$ongkir_valid = $ongkirMap[$jasa_pengiriman] ?? 0;
if ($ongkir_input !== $ongkir_valid || $ongkir_valid === 0) {
    die("❌ Ongkos kirim tidak sesuai dengan jasa pengiriman.");
}
$ongkir = $ongkir_valid;

// Perbarui alamat user jika berubah
$cek_user = mysqli_query($koneksi, "SELECT alamat FROM users WHERE id_user = $id_user");
$data_user = mysqli_fetch_assoc($cek_user);
if ($data_user && trim($data_user['alamat']) !== $alamat) {
    $alamat_baru = mysqli_real_escape_string($koneksi, $alamat);
    mysqli_query($koneksi, "UPDATE users SET alamat = '$alamat_baru' WHERE id_user = $id_user");
}

// Proses barang
$checkout_items = [];
foreach ($checkout_items_raw as $json) {
    $item = json_decode($json, true);
    if (isset($item['id_barang'], $item['jumlah'], $item['ukuran'])) {
        $checkout_items[] = [
            'id_barang' => intval($item['id_barang']),
            'jumlah' => intval($item['jumlah']),
            'ukuran' => mysqli_real_escape_string($koneksi, $item['ukuran'])
        ];
    }
}
if (count($checkout_items) === 0) {
    die("❌ Tidak ada item yang dipilih.");
}

// Hitung subtotal
$subtotal = 0;
foreach ($checkout_items as $item) {
    $id_barang = $item['id_barang'];
    $jumlah = $item['jumlah'];
    $query = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id_barang = $id_barang");
    if ($data = mysqli_fetch_assoc($query)) {
        $harga = intval($data['harga']);
        $subtotal += $harga * $jumlah;
    } else {
        die("❌ Barang tidak ditemukan.");
    }
}

$total_bayar = $subtotal + $ongkir;
$tanggal = date('Y-m-d H:i:s');
$status = 'Menunggu Verifikasi';

// Simpan transaksi
$query_transaksi = mysqli_query($koneksi, "INSERT INTO transaksi (id_user, tanggal_transaksi, total_harga, ongkir, status, jasa_pengiriman)
                        VALUES ('$id_user', '$tanggal', '$subtotal', '$ongkir', '$status', '$jasa_pengiriman')");
if (!$query_transaksi) {
    die("❌ Gagal menyimpan transaksi: " . mysqli_error($koneksi));
}
$id_transaksi = mysqli_insert_id($koneksi);

// Simpan detail transaksi + kurangi stok
foreach ($checkout_items as $item) {
    $id_barang = $item['id_barang'];
    $jumlah = $item['jumlah'];
    $ukuran = $item['ukuran'];

    $query_detail = mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, ukuran)
                                            VALUES ($id_transaksi, $id_barang, $jumlah, '$ukuran')");
    if (!$query_detail) {
        die("❌ Gagal menyimpan detail transaksi: " . mysqli_error($koneksi));
    }

    $query_stok = mysqli_query($koneksi, "UPDATE barang SET stok = stok - $jumlah WHERE id_barang = $id_barang");
    if (!$query_stok) {
        die("❌ Gagal mengurangi stok: " . mysqli_error($koneksi));
    }
}

// Upload bukti jika perlu
$tanggal_bayar = date('Y-m-d H:i:s');
$bukti_url = '-';

if (in_array($metode, ['ovo', 'dana'])) {
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === 0) {
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($_FILES['bukti']['type'], $allowed)) {
            die("❌ File harus JPG/PNG.");
        }

        if (!file_exists('../bukti')) {
            mkdir('../bukti', 0777, true);
        }

        $nama_file = time() . "_" . basename($_FILES['bukti']['name']);
        $lokasi = "../bukti/" . $nama_file;

        if (move_uploaded_file($_FILES['bukti']['tmp_name'], $lokasi)) {
            $bukti_url = $nama_file;
        } else {
            die("❌ Gagal upload bukti.");
        }
    } else {
        die("❌ Bukti pembayaran harus diupload untuk metode ini.");
    }
}

// Simpan data pembayaran
$query_pembayaran = mysqli_query($koneksi, "INSERT INTO pembayaran (id_transaksi, metode_pembayaran, tanggal_bayar, bukti)
                        VALUES ($id_transaksi, '$metode', '$tanggal_bayar', '$bukti_url')");
if (!$query_pembayaran) {
    die("❌ Gagal menyimpan data pembayaran: " . mysqli_error($koneksi));
}

// Kosongkan keranjang
unset($_SESSION['keranjang']);

// Sukses
echo "<script>alert('Checkout berhasil!'); window.location='../home/home.php';</script>";
exit;
?>
