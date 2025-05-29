<?php
session_start();

// Jika sudah login, redirect ke dashboard sesuai role
if (isset($_SESSION['user_id'])) {
    header('Location: halaman_pencari_kerja.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="style_3.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="halaman_utama.html" method="GET">
            <label for="user-type">Login Sebagai:</label>
            <select id="user-type" name="user-type" required>
                <option value="job-seeker">Pencari Kerja</option>
                <option value="company">Perusahaan</option>
            </select>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
