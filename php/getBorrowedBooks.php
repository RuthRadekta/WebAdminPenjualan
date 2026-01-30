<?php
include '../php/db_connection.php';
session_start();
header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['id_anggota'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$idAnggota = $_SESSION['id_anggota'];

// Ambil daftar buku yang dipinjam oleh pengguna
$query = "SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali
          FROM peminjaman p
          JOIN buku b ON p.id_buku = b.id
          WHERE p.id_anggota = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idAnggota);
$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $books]);

$stmt->close();
$conn->close();
?>
