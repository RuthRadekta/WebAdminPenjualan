<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../pages/loginPage.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../pages/style.css">
    <style>
        /* Styling untuk tampilan buku */
        .book-card {
            max-width: 200px;
            margin: 20px;
            background-color: white;
            border-radius: 20%;
        }

        .book-card img {
            max-width: 100%;
            border-radius: 10px;
        }

        .book-card button {
            background-color: #343a40;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            width: 100%;
        }

        body{
            background-color: #FBF9F7;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Sidebar (Kolom 1) -->
            <div class="col-md-3 bg-light d-flex flex-column justify-content-between p-4">
                <div>
                    <h2 class="mb-4">YOUR ACTIVITIES</h2>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="bookshelves-link">Bookshelves</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="borrowed-link">Borrowed Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="settings-link">Settings</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <a href="../index.html" class="nav-link text-dark">Logout</a>
                </div>
            </div>

            <!-- Main Content Area (Kolom 2, 3, 4) -->
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-10">
                        <a style="color: orange; text-decoration: none; font-weight: bold;" href="#" id="explore-link">Explore?</a>
                    </div>
                    <div class="col-md-1">
                        <h6>Profil</h6>
                    </div>
                </div>
                <div class="row h-50">
                    <div class="col-md-12 p-4" id="dynamic-content">
                        <p><b>PETUNJUK:</b> <br> Klik <b>navigasi</b> di samping untuk melihat rak bukumu <br> Klik <b>explore</b> untuk menjelajahi buku :3</p>
                        <!-- Konten dinamis akan muncul di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script2.js"></script>
</body>
</html>
