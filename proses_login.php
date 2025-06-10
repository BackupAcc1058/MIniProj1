<?php
session_start();
require 'config/koneksi.php'; // koneksi ke database

// Tangkap data dari form
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['user-type']; // 'pencari_kerja' atau 'perusahaan'

// Cari user berdasarkan email dan role
$query = "SELECT * FROM users WHERE email = ? AND role = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $email, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Cek password (saat ini belum hash)
    if ($user['password'] === $password) {
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'pencari_kerja') {
            header('Location: halaman_pencari_kerja.php');
        } elseif ($user['role'] === 'perusahaan') {
            header('Location: dashboard_perusahaan.php');
        }
        exit;
    } else {
        echo "Password salah.";
    }
} else {
    echo "<script>alert('Email tidak ditemukan atau role tidak sesuai.'); window.location.href = 'login.php';</script>";
}
?>