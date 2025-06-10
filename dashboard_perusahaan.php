<?php
session_start();
require 'config/koneksi.php';

// Cek login dan role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit;
}

// Ambil id_user dari session
$id_user = $_SESSION['user_id'];

// Ambil id_perusahaan dari tabel perusahaan
$getId = $conn->prepare("SELECT id FROM perusahaan WHERE id_user = ?");
$getId->bind_param("i", $id_user);
$getId->execute();
$getId->bind_result($id_perusahaan);
$getId->fetch();
$getId->close();

// Ambil data lowongan
$stmt = $conn->prepare("SELECT * FROM lowongan WHERE id_perusahaan = ?");
$stmt->bind_param("i", $id_perusahaan);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/dashboard_perusahaan.css?<?php echo time();?>">
</head>
<body>
    <?php
        $customPageTitle = "Dashboard Perusahaan";
        include "include/header.php";
    ?>
    <!-- <h2>Dashboard Perusahaan</h2> -->
    <a href="tambah_lowongan.php">+ Tambah Lowongan</a>
    <table border="1">
        <tr>
            <th>Nama Pekerjaan</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th>Deskripsi</th>
            <th>Syarat</th>
            <th>Gaji</th>
            <th>Batas Lamaran</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_pekerjaan']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td><?= htmlspecialchars($row['jenis_pekerjaan']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td><?= htmlspecialchars($row['syarat']) ?></td>
            <td><?= htmlspecialchars($row['rentang_gaji']) ?></td>
            <td><?= $row['batas_lamaran'] ?></td>
            <td>
                <a href="edit_lowongan.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="hapus_lowongan.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a> |
                <a href="daftar_pelamar.php?id=<?= $row['id'] ?>">Pelamar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php
        include "include/footer.php";
    ?>
</body>
</html>