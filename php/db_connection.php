<?php
// db_connection.php

// Definisikan variabel untuk koneksi database
$host = 'localhost';  // atau alamat server database Anda
$username = 'root';    // username database Anda
$password = '';        // password database Anda
$database = 'noctics'; // nama database Anda

// Koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
