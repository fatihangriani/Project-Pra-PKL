<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

// Cek jika form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['balasan'])) {
    $id = $_POST['id'];
    $balasan = mysqli_real_escape_string($koneksi, $_POST['balasan']);

    $query = mysqli_query($koneksi, "UPDATE komentar SET balasan = '$balasan' WHERE id = $id");

    if ($query) {
        echo "<script>alert('Balasan berhasil dikirim!'); window.location='pesan.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal membalas komentar!');</script>";
    }
}

// Jika belum disubmit, tampilkan form balasan
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $data = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id = $id");
    $komentar = mysqli_fetch_assoc($data);

    if ($komentar) {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balas Komentar</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .comment-box {
            background: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #3498db;
            margin-bottom: 20px;
            border-radius: 0 4px 4px 0;
        }
        .comment-meta {
            font-size: 0.9em;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        .comment-text {
            white-space: pre-line;
        }
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 16px;
            transition: border 0.3s;
            margin-bottom: 15px;
        }
        textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2980b9;
        }
        .btn-cancel {
            background-color: #95a5a6;
            margin-left: 10px;
        }
        .btn-cancel:hover {
            background-color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Balas Komentar</h2>
        
        <div class="comment-box">
            <div class="comment-meta">
                Dari: <strong><?= htmlspecialchars($komentar['nama']) ?></strong> | 
                Email: <?= htmlspecialchars($komentar['email']) ?> | 
                Tanggal: <?= date('d M Y H:i', strtotime($komentar['tanggal'])) ?>
            </div>
            <div class="comment-text">
                <?= nl2br(htmlspecialchars($komentar['pesan'])) ?>
            </div>
        </div>
        
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $komentar['id'] ?>">
            <label for="balasan"><strong>Balasan Anda:</strong></label><br>
            <textarea name="balasan" id="balasan" rows="6" placeholder="Tulis balasan Anda di sini..." required><?= isset($komentar['balasan']) ? htmlspecialchars($komentar['balasan']) : '' ?></textarea><br>
            <button type="submit">Kirim Balasan</button>
            <a href="pesan.php" class="btn-cancel" style="text-decoration: none; display: inline-block; padding: 12px 20px;">Batal</a>
        </form>
    </div>
</body>
</html>
<?php
    } else {
        echo "<div class='container'><p style='color: #e74c3c;'>Komentar tidak ditemukan.</p></div>";
    }
} else {
    echo "<div class='container'><p style='color: #e74c3c;'>ID komentar tidak valid.</p></div>";
}
?>