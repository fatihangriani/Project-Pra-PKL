<?php 
$server = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "db_twinkletoes"; 
 
$koneksi = mysqli_connect($server,$username,$password,$database); 
 
if ($koneksi) { 
// echo "berhasil terkoneksi"; 
// } else { 
// echo "gagal terkoneksi"; 
}
?>