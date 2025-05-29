<?php
session_start();
require_once 'config/koneksi.php';

// Cek apakah user sudah login dan memiliki role pencari_kerja
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pencari_kerja') {
    header('Location: login.php');
    exit;
}

// Ambil data lowongan (gunakan mysqli)
$sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, p.nama_perusahaan
        FROM lowongan l
        JOIN perusahaan p ON l.id_perusahaan = p.id
        ORDER BY l.created_at DESC";

$result = mysqli_query($conn, $sql);
$lowongan = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $lowongan[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pencari Kerja</title>
    <link rel="stylesheet" href="style_3.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Selamat Datang, Pencari Kerja!</h2>
        <p><a href="logout.php">Logout</a></p>

        <h3>Lowongan Tersedia:</h3>

        <?php if (empty($lowongan)): ?>
            <p>Belum ada lowongan tersedia.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($lowongan as $l): ?>
                    <li>
                        <strong><?= htmlspecialchars($l['nama_pekerjaan']) ?></strong><br>
                        Perusahaan: <?= htmlspecialchars($l['nama_perusahaan']) ?><br>
                        Kategori: <?= htmlspecialchars($l['kategori']) ?><br>
                        Gaji: <?= htmlspecialchars($l['rentang_gaji']) ?><br>
                        <a href="detail_lowongan.php?id=<?= $l['id'] ?>">Lihat Detail / Lamar</a>
                    </li>
                    <hr>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
