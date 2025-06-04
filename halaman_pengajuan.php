<?php
    session_start();
    require "config/koneksi.php";
    if ($_GET) {
        $id = $_GET['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Finish'])) {
        $id_user = $_SESSION['user_id']; // make sure session contains user ID
        $id_lowongan = $_GET['id'];      // passed via URL

        $cv = $_FILES['cvfile'];
        $portofolio = $_FILES['portfile'];
        $surat_lamaran = $_FILES['suratlmr'];

        // Set target directories
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move uploaded files
        $cvPath = $uploadDir . basename($cv['name']);
        move_uploaded_file($cv['tmp_name'], $cvPath);

        $portofolioPath = !empty($portofolio['name']) ? $uploadDir . basename($portofolio['name']) : null;
        if ($portofolioPath) {
            move_uploaded_file($portofolio['tmp_name'], $portofolioPath);
        }

        $suratPath = !empty($surat_lamaran['name']) ? $uploadDir . basename($surat_lamaran['name']) : null;
        if ($suratPath) {
            move_uploaded_file($surat_lamaran['tmp_name'], $suratPath);
        }

        // Check if user already applied
        $check = $conn->prepare("SELECT COUNT(*) FROM lamaran WHERE id_user = ? AND id_lowongan = ?");
        $check->bind_param("ii", $id_user, $id_lowongan);
        $check->execute();
        $check->bind_result($existing);
        $check->fetch();
        $check->close();

        if ($existing > 0) {
            echo "<script>alert('Anda sudah pernah melamar pekerjaan ini'); window.history.back();</script>";
            exit;
        }

        // Continue to insert
        $stmt = $conn->prepare("INSERT INTO lamaran (id_user, id_lowongan, cv, portofolio, surat_lamaran) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $id_user, $id_lowongan, $cvPath, $portofolioPath, $suratPath);


        if ($stmt->execute()) {
            echo "<script>alert('Lamaran berhasil dikirim!'); window.location='somepage.php';</script>";
            header("Location: detail_lowongan.php?id=$id_lowongan");
        } else {
            echo "<script>alert('Gagal mengirim lamaran.');</script>";
        }
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
    ?>
    <fieldset id="detfield">
    <main class="form-panel">
        <form method="POST" enctype="multipart/form-data">
            <fieldset class="field-form">
                <legend class="app-form">
                    <h2>Application Form</h2>
                </legend>
                <center>
                <table>
                    <tr>
                        <td>
                            <label for="cvfile">CV: </label>
                        </td>
                        <td>
                            <input type="file" accept=".pdf" name="cvfile" id="CV" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="portfile">Portofolio: </label>
                        </td>
                        <td>
                            <input type="file" accept=".pdf" name="portfile" id="PF">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="suratlmr">Surat Pelamaran : </label>
                        </td>
                        <td>
                            <input type="file" name="suratlmr" id="LT">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="Finish" id="FIN">
                        </td>
                    </tr>
                </table>
                </center>
            </fieldset>
        </form>
    </main>
    </fieldset>
    <?php
        include "include/footer.php";
    ?>
</body>
</html>