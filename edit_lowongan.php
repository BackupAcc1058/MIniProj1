<?php
session_start();
require 'config/koneksi.php';

$id = $_GET['id'];

// Ambil data
$stmt = $conn->prepare("SELECT * FROM lowongan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $_POST['nama_pekerjaan'];
    $kategori = $_POST['kategori'];
    $jenis = $_POST['jenis_pekerjaan'];
    $gaji = $_POST['rentang_gaji'];
    $deskripsi = $_POST['deskripsi'];
    $syarat = $_POST['syarat'];
    $batas = $_POST['batas_lamaran'];

    $stmt = $conn->prepare("UPDATE lowongan SET nama_pekerjaan=?, kategori=?, jenis_pekerjaan=?, rentang_gaji=?, deskripsi=?, syarat=?, batas_lamaran=? WHERE id=?");
    $stmt->bind_param("sssssssi", $nama, $kategori, $jenis, $gaji, $deskripsi, $syarat, $batas, $id);
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
    <title>Edit Lowongan</title>
    <link rel="stylesheet" href="css/edit_lowongan.css">
</head>
<body>
    <?php
        $customPageTitle = "Edit Lowongan";
        include "include/header.php";
    ?>
    <form method="POST">
        <h2>Edit Lowongan</h2>
        <input type="text" name="nama_pekerjaan" value="<?= $data['nama_pekerjaan'] ?>" required><br>
        <input type="text" name="kategori" value="<?= $data['kategori'] ?>" required><br>
        <input type="text" name="jenis_pekerjaan" value="<?= $data['jenis_pekerjaan'] ?>" required><br>
        <input type="text" name="rentang_gaji" value="<?= $data['rentang_gaji'] ?>"><br>
        <textarea name="deskripsi"><?= $data['deskripsi'] ?></textarea><br>
        <textarea name="syarat"><?= $data['syarat'] ?></textarea><br>
        <input type="date" name="batas_lamaran" value="<?= $data['batas_lamaran'] ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
    <?php
        include "include/footer.php";
    ?>
</html>
