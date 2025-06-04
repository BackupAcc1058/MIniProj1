<?php
    session_start();
    require 'config/koneksi.php';
    if ($_GET) {
        $id = $_GET['id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/detail.css">
    </head>
    <body>
        <?php
            include "include/header.php";
            // Ambil data lowongan
            $stmt = $conn->prepare("SELECT * FROM lowongan WHERE id_perusahaan = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
        <fieldset id="detfield">
        <div id="work">
            <?php while ($row = $result->fetch_assoc()): ?>
                    <h1 class="nam-det"><?= htmlspecialchars($row['nama_pekerjaan']) ?></h1>
                    <h3><?= htmlspecialchars($row['kategori']) ?></h3>
                    <h4><?= htmlspecialchars($row['jenis_pekerjaan']) ?></h4>
                    <h5>Deskripsi: </h5>
                    <p><?= htmlspecialchars($row['deskripsi'])?></p>
                    <p>Rentang Gaji: <?= htmlspecialchars($row['rentang_gaji']) ?></p>
                    <p>Batas Lamaran: <?= $row['batas_lamaran'] ?></p>
            <?php endwhile; ?>
            <?php
                if ($_SESSION) {
                    if ($_SESSION['role'] == 'pencari_kerja') {
                        echo "<a id='btnlamar' href='halaman_pengajuan.php?id=$id'>Lamar</a>";
                    } else {
                        echo "<a id='elselamar' href='#'>Lamar</a>";
                    }
                } else {
                    echo "<a id='loginlamar' href='#'>Lamar</a>";
                }
            
            ?>
         </div>
         </fieldset>
        <?php
            include "include/footer.php";
        ?>
        <script src="js/lamarHandler.js"></script>
    </body>
</html>