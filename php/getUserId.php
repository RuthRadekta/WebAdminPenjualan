<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['id_karyawan'])) {
    echo json_encode(['userId' => $_SESSION['id_karyawan']]); // Return the correct session variable for the member ID
} else {
    echo json_encode(['userId' => null]); // Or handle it as you prefer
}
?>
