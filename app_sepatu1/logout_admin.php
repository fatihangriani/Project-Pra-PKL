<?php
session_start();
session_unset(); // Menghapus semua data session
session_destroy(); // Menghancurkan session
echo "<script>alert('Logout berhasil.'); window.location='login_admin.php';</script>";
exit;
?>
