<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'config/koneksi.php';

echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

$role     = $_POST['role'];
$email    = $_POST['email'];
// $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //ini di hash
$password = $_POST['password']; // ini normal

$cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
$cek->bind_param("s", $email);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    die("Email sudah digunakan");
}

$stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $password, $role);
if (!$stmt->execute()) {
    die("Gagal simpan user: " . $stmt->error);
}
$user_id = $stmt->insert_id;

if ($role === 'pencari_kerja') {
    $nama = $_POST['nama_lengkap'];
    $ttl  = $_POST['tanggal_lahir'];
    $hp   = $_POST['nomor_hp'];

    echo "Pencari kerja: $nama, $ttl, $hp<br>";

    $stmt2 = $conn->prepare("INSERT INTO pencari_kerja (id_user, nama_lengkap, tanggal_lahir, nomor_hp) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("isss", $user_id, $nama, $ttl, $hp);
    if (!$stmt2->execute()) {
        die("Gagal simpan pencari kerja: " . $stmt2->error);
    }

} elseif ($role === 'perusahaan') {
    echo "Perusahaan (skip dulu)";
}

echo "SUKSES!";
exit;
