<?php
// Menampilkan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connection.php';

// Pastikan koneksi berhasil
if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Query untuk mengambil data peminjaman, buku, dan anggota
$sql = "SELECT
    peminjaman.id_transaksi,
    peminjaman.id_anggota,
    peminjaman.id_buku,
    buku.judul,
    anggota.nama_anggota,
    peminjaman.tanggal_pinjam,
    peminjaman.tanggal_kembali
FROM peminjaman
JOIN buku ON peminjaman.id_buku = buku.id
JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota;
";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Cek apakah query berhasil dijalankan
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to retrieve data']);
    exit;
}

// Jika tidak ada data yang ditemukan
if (mysqli_num_rows($result) == 0) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'No books available']);
    exit;
}

// Menyimpan hasil query dalam array
$peminjaman_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $peminjaman_data[] = $row;
}

// Log data yang diambil
error_log(print_r($peminjaman_data, true)); // Log data ke error log

// Mengembalikan data dalam format JSON
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'data' => $peminjaman_data]);

// Tutup koneksi
mysqli_close($conn);
?>
