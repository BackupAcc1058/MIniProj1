<?php

$host = 'localhost';
$user = 'root';
$pass = ''; 
$db   = 'portal_lowongan';

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset ke utf8mb4 untuk dukung karakter khusus
mysqli_set_charset($conn, 'utf8mb4');
?>
