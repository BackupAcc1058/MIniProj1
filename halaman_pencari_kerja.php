<?php
session_start();
require_once 'config/koneksi.php';

$search = isset($_POST['src']) ? mysqli_real_escape_string($conn, $_POST['src']) : '';

if ($search) {
    $sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, l.jenis_pekerjaan, l.deskripsi, l.syarat, l.batas_lamaran, p.nama_perusahaan
            FROM lowongan l
            JOIN perusahaan p ON l.id_perusahaan = p.id
            WHERE (l.nama_pekerjaan LIKE '%$search%' 
                OR l.kategori LIKE '%$search%' 
                OR l.jenis_pekerjaan LIKE '%$search%' 
                OR l.deskripsi LIKE '%$search%' 
                OR l.syarat LIKE '%$search%')
              AND l.batas_lamaran >= CURDATE()
            ORDER BY l.id DESC";
} else {
    $sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, l.batas_lamaran, p.nama_perusahaan
            FROM lowongan l 
            JOIN perusahaan p ON l.id_perusahaan = p.id
            WHERE l.batas_lamaran >= CURDATE()
            ORDER BY l.id DESC";
}

$result = mysqli_query($conn, $sql);
$lowongan = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $lowongan[] = $row;
    }
}

// $lowongan = [];

// if ($result && mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $lowongan[] = $row;
//     }
// }

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

// $sql = "SELECT l.id, l.nama_pekerjaan, l.kategori, l.rentang_gaji, l.batas_lamaran, p.nama_perusahaan
//         FROM lowongan l
//         JOIN perusahaan p ON l.id_perusahaan = p.id
//         WHERE l.batas_lamaran >= CURDATE()
//         ORDER BY l.id DESC";


// $result = mysqli_query($conn, $sql);

// $lowongan = [];

// if ($result && mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $lowongan[] = $row;
//     }
// }

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Pencari Kerja</title>
    <link rel="stylesheet" href="css/halaman_pencari_kerja.css?<?php echo time(); ?>">
</head>

<body>
    <div class="wrapper">
        <?php
        include "include/header.php";
        ?>

        <div class="dashboard-container">
            <h2>Selamat Datang, Pencari Kerja!</h2>
            <!-- <p><a href="logout.php">Logout</a></p> -->

            <!-- Form Pencarian -->
            <form action="" method="post" class="search-bar">
                <input class="searchtext" type="search" name="src" id="SR" placeholder="Cari lowongan...">
                <input class="searchbutton" type="submit" name="src-sub" id="SR-sub" value="Cari">
            </form>

            <h3>Lowongan Tersedia:</h3>
            <!-- <form action="halaman_pencari_kerja.php" method="GET" style="margin-bottom: 20px;">
                <input type="text" name="keyword" placeholder="Cari pekerjaan, kategori, atau perusahaan..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" style="padding: 6px; width: 300px;">
                <button type="submit" style="padding: 6px;">Cari</button>
            </form> -->

            <?php if (empty($lowongan)): ?>
                <p>Belum ada lowongan tersedia.</p>
            <?php else: ?>
                <ul>
                    <main class="form-panel">
                        <table cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
                            <tr>
                                <?php
                                $i = 0;
                                foreach ($lowongan as $l):
                                    if ($i > 0 && $i % 3 == 0) { // kalo udah ada 3 konten, buat baris baru
                                        echo "</tr><tr>";
                                    }
                                ?>
                                    <td>
                                        <div class="job-job">
                                            <strong><?= htmlspecialchars($l['nama_pekerjaan']) ?></strong><br>
                                            Perusahaan: <?= htmlspecialchars($l['nama_perusahaan']) ?><br>
                                            Kategori: <?= htmlspecialchars($l['kategori']) ?><br>
                                            Gaji: <?= htmlspecialchars($l['rentang_gaji']) ?><br>
                                            Batas Lamaran: <?= htmlspecialchars($l['batas_lamaran']) ?><br>
                                            <a class="detail" href="detail_lowongan.php?id=<?= $l['id'] ?>">Lihat Detail / Lamar</a>
                                        </div>
                                    </td>
                                <?php
                                    $i++;
                                endforeach;
                                ?>
                            </tr>
                        </table>
                    </main>
                </ul>
            <?php endif; ?>
        </div>

        <?php
        include "include/footer.php";
        ?>
    </div>
</body>

</html>