<?php
// Include database connection
include '../php/db_connection.php';

// Query to get all employees from the karyawan table
$query = "SELECT id_karyawan, username_karyawan, password_karyawan, nama_karyawan, notelp_karyawan, alamat_karyawan, created_at FROM karyawan";
$result = mysqli_query($conn, $query);

$employees = [];
if (!$result) {
    // Handle query failure
    http_response_code(500); // Internal server error
    echo json_encode(['error' => 'Failed to retrieve employees.', 'details' => mysqli_error($conn)]);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $employees[] = $row; // Store each employee in the array
}

// Return the employees as a JSON response
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'data' => $employees]);

// Close the database connection
mysqli_close($conn);
?>
