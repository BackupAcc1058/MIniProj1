<?php
session_start();
require 'config/koneksi.php';

// Cek login dan role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit;
}

// Ambil id lowongan dari GET
$id_lowongan = $_GET['id'] ?? null;

if (!$id_lowongan) {
    echo "ID lowongan tidak valid.";
    exit;
}

// Ambil data pelamar untuk lowongan tertentu
$query = "SELECT u.email, pk.nama_lengkap, pk.nomor_hp,
                 l.cv, l.portofolio, l.surat_lamaran
          FROM lamaran l
          JOIN users u ON l.id_user = u.id
          JOIN pencari_kerja pk ON pk.id_user = u.id
          WHERE l.id_lowongan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_lowongan);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="css/daftar_pelamar.css">
</head>
<body>
    <?php
        $customPageTitle = "Daftar Pelamar";
        include "include/header.php";
    ?>
    <h2>Daftar Pelamar</h2>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Nomor HP</th>
            <th>CV</th>
            <th>Portofolio</th>
            <th>Surat Lamaran</th>
        </tr>
    
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['nomor_hp']) ?></td>
            <td><a href="<?= $row['cv'] ?>" target="_blank">Lihat CV</a></td>
            <td><?= $row['portofolio'] ? "<a href='{$row['portofolio']}' target='_blank'>Lihat</a>" : "Tidak ada" ?></td>
            <td><?= $row['surat_lamaran'] ? "<a href='{$row['surat_lamaran']}' target='_blank'>Lihat</a>" : "Tidak ada" ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php
        include "include/footer.php";
    ?>
</body>
</html>
