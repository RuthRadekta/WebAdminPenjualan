<?php
// Include database connection
include '../php/db_connection.php';

// Get the raw POST data and decode the JSON
$data = json_decode(file_get_contents('php://input'), true);

// Check if id_karyawan is provided
if (isset($data['id_karyawan'])) {
    $id_karyawan = $data['id_karyawan'];

    // Prepare the delete query
    $query = "DELETE FROM karyawan WHERE id_karyawan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_karyawan);

    // Execute and check if successful
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
    }

    $stmt->close();
} else {
    error_log("Invalid employee ID.");
    echo json_encode(['success' => false, 'message' => 'Invalid employee ID.']);
}

$conn->close();
?>
