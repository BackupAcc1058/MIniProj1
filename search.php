<?php
// Koneksi ke database
$conn = new mysqli("localhost", "username", "password", "nama_database");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil keyword dari form
$search = isset($_POST['src']) ? $conn->real_escape_string($_POST['src']) : '';

// Query SQL dengan pencarian di beberapa kolom
$sql = "SELECT * FROM pekerjaan 
        WHERE nama_pekerjaan LIKE '%$search%' 
        OR kategori LIKE '%$search%' 
        OR jenis_pekerjaan LIKE '%$search%' 
        OR deskripsi LIKE '%$search%' 
        OR syarat LIKE '%$search%'";

$result = $conn->query($sql);

// Tampilkan hasil
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Nama Pekerjaan</th><th>Kategori</th><th>Jenis</th><th>Deskripsi</th><th>Syarat</th><th>Gaji</th><th>Batas Lamaran</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nama_pekerjaan']}</td>
                <td>{$row['kategori']}</td>
                <td>{$row['jenis_pekerjaan']}</td>
                <td>{$row['deskripsi']}</td>
                <td>{$row['syarat']}</td>
                <td>{$row['rentang_gaji']}</td>
                <td>{$row['batas_lamaran']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada hasil ditemukan.";
}
$conn->close();
?>
