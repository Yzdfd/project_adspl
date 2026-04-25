<?php
// Konfigurasi Database
$host = 'localhost';
$user = 'root';
$password = ''; // Ubah sesuai password MySQL Anda
$database = 'Percobaan';

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset ke utf8
$conn->set_charset("utf8");
?>
