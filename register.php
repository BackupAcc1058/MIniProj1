<?php
    if (isset($_SESSION['user_id'])) {
    header('Location: halaman_pencari_kerja.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="style_3.css">
</head>
<body>
    <div class="login-container">
        <h2>Registrasi Akun</h2>

        <?php if (isset($_GET['error'])): ?>
            <p style="color:red"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>

        <form action="proses_registrasi.php" method="POST" enctype="multipart/form-data">
            <label for="role">Daftar Sebagai:</label>
            <select name="role" id="role" required>
                <option value="pencari_kerja">Pencari Kerja</option>
                <option value="perusahaan">Perusahaan</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <div id="form-pencari-kerja">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap">

                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir">

                <label for="nomor_hp">No HP:</label>
                <input type="text" name="nomor_hp" id="nomor_hp">
            </div>

            <div id="form-perusahaan">
                <label for="nama_perusahaan">Nama Perusahaan:</label>
                <input type="text" name="nama_perusahaan" id="nama_perusahaan">

                <label for="logo">Logo (opsional):</label>
                <input type="file" name="logo" id="logo">

                <label for="lokasi">Lokasi:</label>
                <input type="text" name="lokasi" id="lokasi">
            </div>

            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>

    <script>
        const roleSelect = document.querySelector("select[name='role']");
        const formPekerja = document.getElementById("form-pencari-kerja");
        const formPerusahaan = document.getElementById("form-perusahaan");

        function toggleForm() {
            if (roleSelect.value === 'pencari_kerja') {
                formPekerja.style.display = 'block';
                formPerusahaan.style.display = 'none';
            } else {
                formPekerja.style.display = 'none';
                formPerusahaan.style.display = 'block';
            }
        }

        toggleForm(); // Panggil saat halaman pertama kali dimuat
        roleSelect.addEventListener('change', toggleForm);
    </script>
</body>
</html>
