<?php
include 'koneksi.php'; // Pastikan file ini menghubungkan ke db_penjualan

$query = "SELECT * FROM barang";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang</title>
    <style>
        img {
            width: 150px;
            height: auto;
        }
        .barang-item {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h2>Daftar Barang</h2>

<?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="barang-item">
        <h3><?php echo $row['nama_barang']; ?></h3>
        <p><strong>Merk:</strong> <?php echo $row['merk']; ?></p>
        <p><strong>Kategori:</strong> <?php echo $row['kategori']; ?></p>
        <p><strong>Harga:</strong> Rp<?php echo number_format($row['harga']); ?></p>
        <p><strong>Stok:</strong> <?php echo $row['stok']; ?> pcs</p>
        <p><strong>Jumlah Beli:</strong> <?php echo $row['jumlah_beli']; ?></p>
        <img src="<?php echo $row['foto']; ?>" alt="<?php echo $row['nama_barang']; ?>">
    </div>
    <hr>
<?php endwhile; ?>

</body>
</html>
