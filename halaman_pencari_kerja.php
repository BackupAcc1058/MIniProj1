<?php
session_start();
require_once 'config/koneksi.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
if (!empty($keyword)) {
    $sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, l.batas_lamaran, p.nama_perusahaan
            FROM lowongan l
            JOIN perusahaan p ON l.id_perusahaan = p.id
            WHERE (l.nama_pekerjaan LIKE ? OR l.kategori LIKE ? OR p.nama_perusahaan LIKE ?)
            AND l.batas_lamaran >= CURDATE()
            ORDER BY l.id DESC";
            
            $stmt = $conn->prepare($sql);
            $searchParam = "%" . $keyword . "%";
            $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
            $stmt->execute();
            $result = $stmt->get_result();
} else {
    $sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, l.batas_lamaran, p.nama_perusahaan
            FROM lowongan l
            JOIN perusahaan p ON l.id_perusahaan = p.id
            WHERE l.batas_lamaran >= CURDATE()
            ORDER BY l.id DESC";
    $result = mysqli_query($conn, $sql);
}
$lowongan = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $lowongan[] = $row;
    }
}

// Cek apakah user sudah login dan memiliki role pencari_kerja
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pencari_kerja') {
//     header('Location: login.php');
//     exit;
// }

// Ambil data lowongan (gunakan mysqli)
// $sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, p.nama_perusahaan
//         FROM lowongan l
//         JOIN perusahaan p ON l.id_perusahaan = p.id
//         ORDER BY l.id DESC";

$sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, l.batas_lamaran, p.nama_perusahaan
        FROM lowongan l
        JOIN perusahaan p ON l.id_perusahaan = p.id
        WHERE l.batas_lamaran >= CURDATE()
        ORDER BY l.id DESC";


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
    <link rel="stylesheet" href="css/halaman_pencari_kerja.css">
</head>
<body>
     <div class="wrapper">
    <?php
        include "include/header.php";
    ?>
   
        <div class="dashboard-container">
            <h2>Selamat Datang, Pencari Kerja!</h2>
            <!-- <p><a href="logout.php">Logout</a></p> -->

            <h3>Lowongan Tersedia:</h3>
            <form action="halaman_pencari_kerja.php" method="GET" style="margin-bottom: 20px;">
                <input type="text" name="keyword" placeholder="Cari pekerjaan, kategori, atau perusahaan..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" style="padding: 6px; width: 300px;">
                <button type="submit" style="padding: 6px;">Cari</button>
            </form>

            <?php if (empty($lowongan)): ?>
                <p>Belum ada lowongan tersedia.</p>
            <?php else: ?>
                <ul>
                    <main class="form-panel">
                    <?php foreach ($lowongan as $l): ?>
                        <!-- <div class="job-job">
                            <img class="job-img" src="images/gameloftjpg.jpg" alt="Gameloft">
                            <img class="job-title" src="images/Gameloft-logo-and-wordmark.png" alt="">
                            <a class="detail" href="halaman_detail.html">Learn More</a>
                            <p> >>> Recruiting Lead Art Position...</p>
                        </div> -->
                            <div class="job-job">
                                <strong><?= htmlspecialchars($l['nama_pekerjaan']) ?></strong><br>
                                Perusahaan: <?= htmlspecialchars($l['nama_perusahaan']) ?><br>
                                Kategori: <?= htmlspecialchars($l['kategori']) ?><br>
                                Gaji: <?= htmlspecialchars($l['rentang_gaji']) ?><br>
                                Batas Lamaran: <?= htmlspecialchars($l['batas_lamaran']) ?><br>
                                <a class="detail" href="detail_lowongan.php?id=<?= $l['id'] ?>">Lihat Detail / Lamar</a>
                            </div>
                            <!-- <strong><?= htmlspecialchars($l['nama_pekerjaan']) ?></strong><br>
                            Perusahaan: <?= htmlspecialchars($l['nama_perusahaan']) ?><br>
                            Kategori: <?= htmlspecialchars($l['kategori']) ?><br>
                            Gaji: <?= htmlspecialchars($l['rentang_gaji']) ?><br>
                            <a href="detail_lowongan.php?id=<?= $l['id'] ?>">Lihat Detail / Lamar</a> -->
                        </li>
                        <hr>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    
    <?php
        include "include/footer.php";
    ?>
    </div>
</body>
</html>
