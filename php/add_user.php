<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../php/db_connection.php';

// Check database connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Prepare and bind parameters
$username_karyawan = $data['username_karyawan'] ?? ''; // Username karyawan
$password_karyawan = $data['password_karyawan'] ?? ''; // Password karyawan
$nama_karyawan = $data['nama_karyawan'] ?? ''; // Nama karyawan
$notelp_karyawan = $data['notelp_karyawan'] ?? ''; // Nomor telepon karyawan
$alamat_karyawan = $data['alamat_karyawan'] ?? ''; // Alamat karyawan
$date_joined = date('Y-m-d H:i:s'); // Current date and time

// Check if all required data is present
if (empty($username_karyawan) || empty($password_karyawan) || empty($nama_karyawan) || empty($notelp_karyawan) || empty($alamat_karyawan)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'All fields are required.']);
    exit;
}

// Hash the password for security (optional)
//$hashed_password = password_hash($password, PASSWORD_DEFAULT);
// No hashing for the password
$plain_password = $password; // Use plain password directly

// Prepare the SQL statement
$query = "INSERT INTO karyawan (username_karyawan, password_karyawan, nama_karyawan, notelp_karyawan, alamat_karyawan, created_at) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssssss', $username, $plain_password, $nama_karyawan, $notelp_karyawan, $alamat_karyawan, $date_joined);

// Execute the statement and check for success
if ($stmt->execute()) {
    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'User added successfully.']);
} else {
    http_response_code(500); // Internal server error
    echo json_encode(['error' => 'Failed to add user.', 'details' => $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
