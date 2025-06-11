<?php
    session_start();
    require "config/koneksi.php";

    // Cek apakah user sudah login dan memiliki role pencari_kerja
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pencari_kerja') {
        header('Location: login.php');
        exit;
    }

    if ($_GET) {
        $id = $_GET['id'];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Finish'])) {
        $id_user = $_SESSION['user_id']; // make sure session contains user ID
        $id_lowongan = $_GET['id'];      // passed via URL

        $cv = $_FILES['cvfile'];
        $portofolio = $_FILES['portfile'];
        $surat_lamaran = $_FILES['suratlmr'];

        // Validate file sizes (max 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB

        function validateFileSize($file, $label) {
            global $maxSize;
            if ($file['error'] === 0 && $file['size'] > $maxSize) {
                echo "<script>alert('File $label melebihi ukuran maksimal 5MB.'); window.history.back();</script>";
                exit;
            }
        }

        validateFileSize($cv, "CV");

        if (!empty($portofolio['name'])) {
            validateFileSize($portofolio, "Portofolio");
        }

        if (!empty($surat_lamaran['name'])) {
            validateFileSize($surat_lamaran, "Surat Pelamaran");
        }

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
    <title>Halaman Pengajuan</title>
    <link rel="stylesheet" href="css/halaman_pengajuan.css?<?php echo time();?>">
</head>

<body>
    <?php
        $customPageTitle = "Aplication Form";
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
                            <label for="Fullname">Nama Lengkap: </label>
                        </td>
                        <td>
                            <input type="text" name="Fullname" id="FN" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="Birthdate">Tgl Lahir: </label>
                        </td>
                        <td>
                            <input type="date" name="Birthdate" id="DOB" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="Email">Email: </label>
                        </td>
                        <td>
                            <input type="email" name="Email" id="EM" required value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="PhoneNum">No. HP:  </label>
                        </td>
                        <td>
                            <input type="text" name="PhoneNum" id="PN" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cvfile">CV: </label>
                        </td>
                        <td>
                            <input type="file" accept=".pdf" name="cvfile" id="CV" required title="Max 5MB PDF">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="portfile">Portofolio: </label>
                        </td>
                        <td>
                            <input type="file" accept=".pdf" name="portfile" id="PF" title="Max 5MB PDF">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="suratlmr">Surat Pelamaran : </label>
                        </td>
                        <td>
                            <input type="file" name="suratlmr" id="LT" title="Max 5MB PDF">
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
    <script src="js/validate-upload.js"></script>
</body>
</html>