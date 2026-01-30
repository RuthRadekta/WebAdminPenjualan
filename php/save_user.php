<?php
// save_user.php
include '../php/db_connection.php'; // Pastikan Anda menyertakan skrip koneksi DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari POST
    $nama = $_POST['nama_karyawan']; // Sesuaikan dengan nama input form Anda
    $username = $_POST['username_karyawan']; // Sesuaikan dengan nama input form Anda
    $notelp = $_POST['notelp_karyawan']; // Nomor telepon karyawan
    $alamat = $_POST['alamat_karyawan']; // Alamat karyawan

    // Persiapkan kueri untuk memasukkan data karyawan
    $stmt = $conn->prepare("INSERT INTO karyawan (nama_karyawan, username_karyawan, notelp_karyawan, alamat_karyawan, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $nama, $username, $notelp, $alamat); // "ssss" berarti semua string

    // Eksekusi kueri
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Data karyawan berhasil disimpan.']); // Mengembalikan format JSON
    } else {
        echo json_encode(['message' => 'Error: ' . $stmt->error]); // Tampilkan error jika ada
    }

    $stmt->close();
    $conn->close();
}
?>
