<?php
session_start(); // Mulai sesi

// Hapus semua session
session_unset();

// Hancurkan session
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit;
