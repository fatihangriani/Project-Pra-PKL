<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

    $username= $_POST['username'];
    $email= $_POST['email'];
    $p= md5($_POST['password']);
    $alamat= $_POST['alamat'];
    $no_hp= $_POST['no_hp'];
    $role = $_POST['role'];

    $sql ="INSERT INTO users (username , email, alamat, no_hp, role,password) 
    VALUES ('$username','$email','$alamat','$no_hp','$role','$p')";


$query = mysqli_query($koneksi,$sql);
if($query){
    header("location:pelanggan.php");
}else{
    echo "gagal menyimpan:" .mysqli_error($koneksi);
}

?>