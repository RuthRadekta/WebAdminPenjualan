<?php
// Include database connection
include '../php/db_connection.php';

// Query to get all books from the buku table
$query = "SELECT id, judul, stok FROM barang";
$result = mysqli_query($conn, $query);

$books = [];
if (!$result) {
    // Handle query failure
    http_response_code(500); // Internal server error
    echo json_encode(['error' => 'Failed to retrieve books.']);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row; // Store each book in the array
}

// Return the books as a JSON response
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'data' => $books]);

// Close the database connection
mysqli_close($conn);
?>
