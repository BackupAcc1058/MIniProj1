<?php
session_start();
require 'config/koneksi.php';

$id = $_GET['id'];

// Cek apakah lowongan memiliki pelamar
$cek = $conn->prepare("SELECT COUNT(*) as total FROM lamaran WHERE id_lowongan = ?");
$cek->bind_param("i", $id);
$cek->execute();
$cek->bind_result($total);
$cek->fetch();
$cek->close();

if ($total > 0) {
    echo "<script>alert('Lowongan tidak bisa dihapus karena sudah ada pelamar.');</script>";
    header("Refresh:0; url=dashboard_perusahaan.php");
    exit;
} else {
    // Hapus jika tidak ada pelamar
    $stmt = $conn->prepare("DELETE FROM lowongan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    header("Location: dashboard_perusahaan.php");
    exit;
}
?>