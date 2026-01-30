<?php
include '../php/db_connection.php'; // Sesuaikan dengan file koneksi Anda

// Tambahkan header untuk JSON
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mendapatkan data dari request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $id = $data['id_karyawan'];
    $nama = $data['nama_karyawan'];
    $username = $data['username_karyawan'];
    $notelp = $data['notelp_karyawan'];
    $alamat = $data['alamat_karyawan'];

    // Kueri update
    $stmt = $conn->prepare("UPDATE karyawan SET nama_karyawan=?, username_karyawan=?, notelp_karyawan=?, alamat_karyawan=? WHERE id_karyawan=?");
    $stmt->bind_param("ssssi", $nama, $username, $notelp, $alamat, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update employee.']);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
