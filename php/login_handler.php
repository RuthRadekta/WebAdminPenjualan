<?php
// Include database connection
include 'db_connection.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prevent SQL injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Query untuk memeriksa apakah pengguna adalah admin atau anggota
$query = "
    SELECT 'admin' as role, username, NULL as id FROM admin WHERE username='$username' AND password='$password'
    UNION ALL
    SELECT 'karyawan' as role, username_karyawan, id_karyawan as id FROM karyawan WHERE username_karyawan='$username' AND password_karyawan='$password'
";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 1) {
    // Fetch the user data
    $user = mysqli_fetch_assoc($result);

    // Set session berdasarkan role
    $_SESSION['username'] = $user['username'];
    if ($user['role'] == 'admin') {
        $_SESSION['userId'] = null; // Admin does not have userId in this context
        header("Location: ../pages/adminPage.html");
    } else {
        $_SESSION['id_karyawan'] = $user['id']; // Use the correct session variable for members
        header("Location: ../pages/memberPage.html");
    }
    exit();
} else {
    // Invalid login
    echo "<script>alert('Invalid username or password!'); window.location.href = '../pages/loginPage.html';</script>";
}
?>
