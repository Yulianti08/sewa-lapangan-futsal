<?php
session_start(); // Mulai sesi untuk menyimpan data

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $namaPenyewa = $_POST['namaPenyewa'];
    $buktiFile = $_FILES['buktiFile'];

    // Cek apakah file sudah diunggah
    if ($buktiFile['error'] == 0) {
        // Tentukan direktori untuk menyimpan file
        $uploadDir = "uploads/"; // Buat folder 'uploads' untuk menyimpan file
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Tentukan nama file dan lokasi penyimpanan
        $fileName = time() . '_' . basename($buktiFile['name']);
        $filePath = $uploadDir . $fileName;

        // Pindahkan file ke direktori yang ditentukan
        if (move_uploaded_file($buktiFile['tmp_name'], $filePath)) {
            // Simpan data pemesanan dalam session
            $_SESSION['buktiPembayaran'] = [
                'namaPenyewa' => $namaPenyewa,
                'file' => $filePath, // Simpan path file yang sudah diupload
            ];

            $_SESSION['success_message'] = "Bukti pembayaran berhasil diunggah!";
        } else {
            $_SESSION['error_message'] = "Gagal mengunggah bukti pembayaran.";
        }
    } else {
        $_SESSION['error_message'] = "Silakan unggah file bukti pembayaran.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran - Lampung Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #C9E6F0;
            margin: 0;
            padding: 0;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            font-size: 1rem;
            margin-right: 15px;
        }

        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }

        .nav-link.text-danger {
            font-weight: bold;
        }

        ul li {
            padding: 5px 0;
            font-size: 1.1rem;
            color: #495057;
        }

        /* Footer Styling */
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Lampung Futsal</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="penyewaan.php">Penyewaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="layanan.php">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link active" href="bukti.php">Bukti Pembayaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Unggah Bukti Pembayaran</h2>

        <!-- Tampilkan pesan jika ada error atau sukses -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Form Unggah Bukti Pembayaran -->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="namaPenyewa" class="form-label">Nama Penyewa</label>
                <input type="text" class="form-control" id="namaPenyewa" name="namaPenyewa" placeholder="Masukkan nama penyewa" required>
            </div>
            <div class="mb-3">
                <label for="buktiFile" class="form-label">Unggah Bukti Pembayaran</label>
                <input type="file" class="form-control" id="buktiFile" name="buktiFile" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah</button>
        </form>

        <!-- Tampilkan data yang telah dikirimkan -->
        <?php if (isset($_SESSION['buktiPembayaran'])): ?>
            <div class="mt-4">
                <h4>Data Pembayaran:</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Penyewa</th>
                        <th>Bukti Pembayaran</th>
                    </tr>
                    <tr>
                        <td><?php echo $_SESSION['buktiPembayaran']['namaPenyewa']; ?></td>
                        <td>
                            <img src="<?php echo $_SESSION['buktiPembayaran']['file']; ?>" alt="Bukti Pembayaran" style="width: 200px; height: auto;">
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
