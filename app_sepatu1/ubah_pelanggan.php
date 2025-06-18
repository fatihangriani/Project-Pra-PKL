<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$id = $_GET['id_user'];
$sql = "SELECT * FROM users WHERE id_user = '$id'";
$query = mysqli_query($koneksi, $sql);
while ($user = mysqli_fetch_assoc($query)) {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Edit Pelanggan</h2>
    <form action="proses_ubah.php" method="POST">
        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= $user['username'] ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $user['email'] ?>" required>

            <label for="alamat">Alamat:</label>
            <textarea name="alamat" id="alamat" rows="4" required><?= $user['alamat'] ?></textarea>

            <label for="no_hp">No HP:</label>
            <input type="number" name="no_hp" id="no_hp" value="<?= $user['no_hp'] ?>" required>
        </div>

        <button type="submit">Simpan Perubahan</button>
        <a href="pelanggan.php" style="margin-left: 10px;">Batal</a>
    </form>
</body>
</html>

<?php } ?>
