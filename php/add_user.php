<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../php/db_connection.php'; // Pastikan path ini benar

// Check database connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get data from the request (JSON Input)
$data = json_decode(file_get_contents('php://input'), true);

// Prepare variables (Mengambil dari JSON)
$username_karyawan = $data['username_karyawan'] ?? ''; 
$password_karyawan = $data['password_karyawan'] ?? ''; 
$nama_karyawan     = $data['nama_karyawan'] ?? ''; 
$notelp_karyawan   = $data['notelp_karyawan'] ?? ''; 
$alamat_karyawan   = $data['alamat_karyawan'] ?? ''; 
$date_joined       = date('Y-m-d H:i:s'); 

// Check if all required data is present
if (empty($username_karyawan) || empty($password_karyawan) || empty($nama_karyawan)) {
    http_response_code(400); 
    echo json_encode(['error' => 'Username, Password, dan Nama wajib diisi.']);
    exit;
}

// PERBAIKAN UTAMA DISINI:
// Menggunakan variabel yang benar ($password_karyawan), bukan $password yang kosong
$plain_password = $password_karyawan; 

// Prepare the SQL statement
// Pastikan nama tabel di database benar: 'karyawan' atau 'users'? Sesuaikan dengan database Anda.
$query = "INSERT INTO karyawan (username_karyawan, password_karyawan, nama_karyawan, notelp_karyawan, alamat_karyawan, created_at) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);

// PERBAIKAN KEDUA:
// Menggunakan $username_karyawan (input user), BUKAN $username (milik koneksi db/root)
$stmt->bind_param('ssssss', $username_karyawan, $plain_password, $nama_karyawan, $notelp_karyawan, $alamat_karyawan, $date_joined);

// Execute
if ($stmt->execute()) {
    http_response_code(201); 
    echo json_encode(['status' => 'success', 'message' => 'Karyawan berhasil ditambahkan.']);
} else {
    http_response_code(500); 
    echo json_encode(['error' => 'Gagal menambahkan user.', 'details' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>