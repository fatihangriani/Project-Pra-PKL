<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$sql = "SELECT * FROM barang";
if ($cari != '') {
    $sql .= " WHERE nama_barang LIKE '%$cari%' OR merk LIKE '%$cari%'";
}
$query = mysqli_query($koneksi, $sql);
$id = 1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
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
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            color: white;
            position: fixed;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0 20px;
        }
        
        .sidebar ul li {
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 15px;
        }
        
        .sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar ul li a.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }
        
        .menu-bawah {
            position: absolute;
            bottom: 30px;
            width: calc(100% - 40px);
        }
        
        .menu-bawah .logout {
            display: block;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .menu-bawah .logout:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        /* Konten Utama */
        .content {
            margin-left: 250px;
            padding: 30px;
            transition: all 0.3s ease;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        h2 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        /* Tombol */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-tambah {
            background-color: var(--utama);
            color: white;
        }
        
        .btn-tambah:hover {
            background-color: var(--utama-gelap);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        /* Tabel */
         table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
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
      position: sticky;
      top: 0;
    }
    
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    
    tr:hover {
      background-color: #f1f3ff;
    }
        
        /* Gambar Produk */
        .produk-gambar {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        /* Tombol Aksi */
        .btn-aksi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            margin-right: 5px;
            transition: all 0.2s ease;
        }
        
        .btn-ubah {
            background-color: var(--info);
            color: white;
        }
        
        .btn-hapus {
            background-color: var(--bahaya);
            color: white;
        }
        
        .btn-ubah:hover {
            background-color: #3a7bd5;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(72, 149, 239, 0.3);
        }
        
        .btn-hapus:hover {
            background-color: #e5177e;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(247, 37, 133, 0.3);
        }
        
        /* Pencarian */
        .search-container {
            display: flex;
            margin-bottom: 20px;
        }
        
        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px 0 0 6px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: var(--primary);
        }
        
        .search-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0 15px;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            background-color: var(--primary-dark);
        }
        
        /* Responsif */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar h2, .sidebar ul li a span {
                display: none;
            }
            
            .sidebar ul li a i {
                margin-right: 0;
                font-size: 18px;
            }
            
            .content {
                margin-left: 70px;
                padding: 15px;
            }
            
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 10px;
            }
            
            .produk-gambar {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Panel Admin</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
            <li><a href="akun.php"><i class="fas fa-user-cog"></i> <span>Kelola Akun</span></a></li>
            <li><a class="active" href="#"><i class="fas fa-shopping-cart"></i> <span>Kelola Produk</span></a></li>
            <li><a href="pembayaran.php"><i class="fas fa-credit-card"></i> <span>Kelola Pembayaran</span></a></li>
            <li><a href="pesanan.php"><i class="fas fa-box"></i> <span>Kelola Pesanan</span></a></li>
            <li><a href="pelanggan.php"><i class="fas fa-users"></i> <span>Kelola Pengguna</span></a></li>
            <li><a href="pesan.php"><i class="fas fa-comments"></i> <span>Kelola komentar</span></a></li>
            <div class="menu-bawah">
                <a href="logout_admin.php" class="logout"><i class="fas fa-sign-out-alt"></i> <span>Keluar</span></a>
            </div>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h2>Daftar Produk</h2>
            <a href="tambah_produk.php" class="btn btn-tambah"><i class="fas fa-plus"></i> Tambah Produk</a>
        </div>
        
        <div class="card">
            <form method="GET" action="" class="search-container">
                <input 
                    type="text" 
                    name="cari" 
                    class="search-input"
                    placeholder="Cari nama produk atau merk..." 
                    value="<?= htmlspecialchars($cari) ?>"
                >
                <button type="submit" class="search-btn"><i class="fas fa-search"></i> Cari</button>
            </form>
            
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                             <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?= $id++ ?></td>
                            <td>
                                <img src="upload/<?= $data['gambar'] ?>" class="produk-gambar" alt="<?= $data['nama_barang'] ?>">
                            </td>
                            <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                            <td>Rp<?= number_format($data['harga'], 0, ',', '.') ?></td>
                            <td><?= $data['stok'] ?></td>
                             <td><?= htmlspecialchars($data['kategori']) ?></td> 
                            <td><?= htmlspecialchars($data['deskripsi']) ?></td>
                            <td>
                                <a href="ubah_produk.php?id_barang=<?= $data['id_barang'] ?>" class="btn-aksi btn-ubah">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="hapus_produk.php?id_barang=<?= $data['id_barang'] ?>" class="btn-aksi btn-hapus" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>