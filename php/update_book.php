<?php
include '../php/db_connection.php'; // Sesuaikan dengan file koneksi Anda

// Mendapatkan data dari request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $id = $data['id'];
    $judul = $data['judul'];
    $stok = $data['stok'];

    // Kueri update
    $stmt = $conn->prepare("UPDATE barang SET judul=?, stok=? WHERE id=?");
    $stmt->bind_param("sii", $judul, $stok, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update book.']);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
