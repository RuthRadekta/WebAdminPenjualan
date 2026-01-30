<?php
// Include database connection
include '../php/db_connection.php';

// Get data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Prepare and bind parameters
$judul = $data['judul'] ?? '';
$stok = $data['stok'] ?? 0; // Default to 0 if not provided

// Check if all required data is present
if (empty($judul) || !is_numeric($stok)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Judul and stok are required.']);
    exit;
}

// Prepare the SQL statement
$query = "INSERT INTO barang (judul, stok) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $judul, $stok);

// Execute the statement and check for success
if ($stmt->execute()) {
    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Book added successfully.']);
} else {
    http_response_code(500); // Internal server error
    echo json_encode(['error' => 'Failed to add book.', 'details' => $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
