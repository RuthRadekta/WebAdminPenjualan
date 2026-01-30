<?php
include '../php/db_connection.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

$bookId = $data->bookId;
$userId = $data->userId;
$tanggalPinjam = date('Y-m-d');
$tanggalKembali = date('Y-m-d', strtotime('+7 days')); // Misal 7 hari untuk pengembalian

$sql = "INSERT INTO peminjaman (id_buku, id_anggota, tanggal_pinjam, tanggal_kembali) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $bookId, $userId, $tanggalPinjam, $tanggalKembali);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
