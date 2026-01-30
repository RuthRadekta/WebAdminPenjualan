<?php
// Asumsi Anda sudah membuat koneksi ke database
include '../php/db_connection.php'; // Sesuaikan dengan file koneksi Anda

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari POST
    $bookTitle = $_POST['book_title'];
    $bookStock = $_POST['book_stock'];

    // Persiapkan kueri
    $stmt = $conn->prepare("INSERT INTO barang (judul, stok) VALUES (?, ?)");
    $stmt->bind_param("si", $bookTitle, $bookStock); // "si" berarti string dan integer

    // Eksekusi kueri
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Data berhasil disimpan.']); // Mengembalikan format JSON
    } else {
        echo json_encode(['message' => 'Error: ' . $stmt->error]); // Tampilkan error jika ada
    }

    $stmt->close();
    $conn->close();
}
?>
