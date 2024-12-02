<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Kami - Lampung Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling Global */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #243642;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #0B192C;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.7rem;
        }

        .nav-link {
            color: #C9E6F0;
            margin-right: 15px;
            font-size: 1rem;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #C9E6F0;
            text-decoration: underline;
        }

        .nav-link.active {
            color: #024CAA !important;
            font-weight: bold;
        }

        .header {
            background: #C9E6F0;
            text-align: center;
            padding: 40px 20px;
            border-bottom: 2px solid #ddd;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .header p {
            font-size: 1.1rem;
            margin-top: 10px;
            color: #0B192C;
        }

        .service-card img {
            max-height: 200px;
            object-fit: cover;
        }

        .service-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 15px 0;
        }

        footer a {
            color: #0d6efd;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Lampung Futsal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="penyewaan.php">Penyewaan</a></li>
                    <li class="nav-item"><a class="nav-link active" href="layanan.php">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="bukti.php">Bukti Pembayaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="header">
        <h1>Layanan Kami</h1>
        <p>Nikmati berbagai layanan tambahan untuk pengalaman futsal yang lebih baik</p>
    </div>

    <!-- Content -->
    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <img src="https://drive.google.com/thumbnail?id=1COXqtG8G8amylKe3zKtRmqfQ21xccxp9" class="card-img-top" alt="Sewa Sepatu">
                    <div class="card-body">
                        <h5 class="card-title">Sewa Sepatu Futsal</h5>
                        <p class="card-text">Rp 20.000 / pasangan</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                <img src="https://drive.google.com/thumbnail?id=1g0l6iOnWqDf935h2CqfF7zBuNOgO8FFo" class="card-img-top" alt="Sewa bola futsals">
                    <div class="card-body">
                        <h5 class="card-title">Sewa Bola Futsal</h5>
                        <p class="card-text">Rp 10.000 / buah</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <img src="https://drive.google.com/thumbnail?id=1jgVXjSKp_B2h25UmZc6t0HlPnprDuawh" class="card-img-top" alt="Peminjaman Rompi">
                    <div class="card-body">
                        <h5 class="card-title">Peminjaman Rompi Tim</h5>
                        <p class="card-text">Rp 15.000 / 10 buah</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pesanModal" tabindex="-1" aria-labelledby="pesanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel">Pesan Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Terima kasih atas minat Anda! Untuk melakukan pemesanan, hubungi petugas kami di lokasi atau melalui kontak yang tersedia.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5">
        <p>&copy; 2024 Lampung Futsal | <a href="index.php">Home</a> | All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
