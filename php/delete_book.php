<?php
// Include database connection
include '../php/db_connection.php';

// Get the raw POST data and decode the JSON
$data = json_decode(file_get_contents('php://input'), true);

// Check if id_anggota is provided
if (isset($data['id'])) {
    $id = $data['id'];

    // Prepare the delete query
    $query = "DELETE FROM barang WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    // Execute and check if successful
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
    }

    $stmt->close();
} else {
    error_log("Invalid user ID.");
    echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
}

$conn->close();
?>
