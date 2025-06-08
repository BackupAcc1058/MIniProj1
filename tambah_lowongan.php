<?php
session_start();
require 'config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $_POST['nama_pekerjaan'];
    $kategori = $_POST['kategori'];
    $jenis = $_POST['jenis_pekerjaan'];
    $gaji = $_POST['rentang_gaji'];
    $deskripsi = $_POST['deskripsi'];
    $syarat = $_POST['syarat'];
    $batas = $_POST['batas_lamaran'];

    $id_user = $_SESSION['user_id'];
    $getId = $conn->prepare("SELECT id FROM perusahaan WHERE id_user = ?");
    $getId->bind_param("i", $id_user);
    $getId->execute();
    $getId->bind_result($id_perusahaan);
    $getId->fetch();
    $getId->close();

    $stmt = $conn->prepare("INSERT INTO lowongan (id_perusahaan, nama_pekerjaan, kategori, jenis_pekerjaan, rentang_gaji, deskripsi, syarat, batas_lamaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $id_perusahaan, $nama, $kategori, $jenis, $gaji, $deskripsi, $syarat, $batas);
    $stmt->execute();
    header("Location: dashboard_perusahaan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/tambah_lowongan.css">
</head>
<body>
    <?php
        $customPageTitle = "Tambah Lowongan";
        include "include/header.php";
    ?>
    <main class="form-container">
    <form method="POST">
        <h2>Tambah Lowongan</h2>
        <input type="text" name="nama_pekerjaan" placeholder="Nama Pekerjaan" required><br>
        <input type="text" name="kategori" placeholder="Kategori" required><br>
        <input type="text" name="jenis_pekerjaan" placeholder="Jenis Pekerjaan" required><br>
        <input type="text" name="rentang_gaji" placeholder="Rentang Gaji"><br>
        <textarea name="deskripsi" placeholder="Deskripsi Pekerjaan" required></textarea><br>
        <textarea name="syarat" placeholder="Syarat" required></textarea><br>
        <input type="date" name="batas_lamaran" required><br>
        <button type="submit">Simpan</button>
    </form>
    </main>
</body>
    <?php
        include "include/footer.php";
    ?>
</html>