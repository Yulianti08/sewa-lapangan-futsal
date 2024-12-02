<?php
session_start();

// Periksa apakah ada data pemesanan dalam session
if (!isset($_SESSION['pesanan'])) {
    $_SESSION['error_message'] = "Tidak ada data pemesanan untuk diedit.";
    header("Location: penyewaan.php");
    exit();
}

// Data pemesanan saat ini
$pesanan = $_SESSION['pesanan'];

// Cek jika form edit disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Validasi waktu
    if (strtotime($jam_mulai) >= strtotime($jam_selesai)) {
        $_SESSION['error_message'] = "Jam mulai harus lebih awal dari jam selesai.";
    } else {
        // Perbarui data pemesanan
        $_SESSION['pesanan']['nama'] = $nama;
        $_SESSION['pesanan']['tanggal'] = $tanggal;
        $_SESSION['pesanan']['jam_mulai'] = $jam_mulai;
        $_SESSION['pesanan']['jam_selesai'] = $jam_selesai;

        $_SESSION['success_message'] = "Data pemesanan berhasil diperbarui.";
        header("Location: penyewaan.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan - Lampung Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C9E6F0;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Pemesanan</h2>
        <p>Silakan edit informasi penyewaan Anda.</p>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Form Edit -->
        <form action="" method="POST">
            <label for="nama">Nama Pemesan:</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($pesanan['nama']); ?>" required>
            <label for="tanggal">Tanggal Sewa:</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($pesanan['tanggal']); ?>" required>
            <label for="jam_mulai">Jam Mulai:</label>
            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?php echo htmlspecialchars($pesanan['jam_mulai']); ?>" required>
            <label for="jam_selesai">Jam Selesai:</label>
            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="<?php echo htmlspecialchars($pesanan['jam_selesai']); ?>" required>
            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>

        <a href="penyewaan.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
