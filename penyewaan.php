<?php
session_start(); // Memulai session

// Simulasi data pemesanan lapangan (untuk tujuan demonstrasi)
$lapanganA = [["09:00", "10:00"], ["10:30", "12:00"], ["13:00", "14:30"]];
$lapanganB = [["08:00", "09:30"], ["12:00", "13:30"], ["15:00", "16:30"]];

// Harga per jam dan paket
$harga_per_jam = 170000;
$harga_paket = 700000;

// Diskon mahasiswa (20%)
$diskon_mahasiswa = 0.20;

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $lapangan = $_POST['lapangan'];
    $ktm = isset($_POST['ktm']) ? true : false; // Cek apakah menggunakan diskon mahasiswa

    // Jika mahasiswa (ktm), pastikan file KTM diunggah
    $ktm_file = null;
    if ($ktm) {
        if (isset($_FILES['ktm_file']) && $_FILES['ktm_file']['error'] == 0) {
            // Validasi jenis file (hanya gambar)
            $file_tmp = $_FILES['ktm_file']['tmp_name'];
            $file_name = $_FILES['ktm_file']['name'];
            $file_size = $_FILES['ktm_file']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            if (in_array($file_ext, $allowed_extensions)) {
                // Tentukan direktori penyimpanan file
                $upload_dir = 'uploads/ktm/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true); // Membuat folder jika belum ada
                }

                // Tentukan path untuk menyimpan file
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;

                // Pindahkan file ke direktori yang dituju
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Simpan nama file yang sudah diupload
                    $ktm_file = $new_file_name;
                } else {
                    $_SESSION['error_message'] = "Gagal mengunggah file KTM.";
                }
            } else {
                $_SESSION['error_message'] = "File yang diunggah bukan gambar yang valid. Harap unggah file JPG, JPEG, atau PNG.";
            }
        } else {
            $_SESSION['error_message'] = "Harap unggah file KTM untuk mendapatkan diskon mahasiswa.";
        }
    }

    // Cek apakah lapangan yang dipilih sudah dibooking
    $booking_conflict = false;
    if ($lapangan == "A") {
        foreach ($lapanganA as $booking) {
            if (($jam_mulai >= $booking[0] && $jam_mulai < $booking[1]) || ($jam_selesai > $booking[0] && $jam_selesai <= $booking[1])) {
                $booking_conflict = true;
                break;
            }
        }
    } else {
        foreach ($lapanganB as $booking) {
            if (($jam_mulai >= $booking[0] && $jam_mulai < $booking[1]) || ($jam_selesai > $booking[0] && $jam_selesai <= $booking[1])) {
                $booking_conflict = true;
                break;
            }
        }
    }

    if ($booking_conflict) {
        $_SESSION['error_message'] = "Lapangan $lapangan pada jam mulai $jam_mulai dan jam selesai $jam_selesai sudah dibooking.";
    } else {
        // Hitung total harga
        $total_harga = 0;
        $durasi_jam = (strtotime($jam_selesai) - strtotime($jam_mulai)) / 3600;

        if ($durasi_jam >= 5) {
            $total_harga = $harga_paket; // Jika durasi lebih dari 5 jam, gunakan harga paket
        } else {
            $total_harga = $durasi_jam * $harga_per_jam; // Hitung total untuk per jam
        }

        // Diskon mahasiswa
        if ($ktm) {
            $total_harga -= $total_harga * $diskon_mahasiswa;
        }

        // Menambahkan pemesanan baru ke daftar lapangan
        if ($lapangan == "A") {
            $lapanganA[] = [$jam_mulai, $jam_selesai];
        } else {
            $lapanganB[] = [$jam_mulai, $jam_selesai];
        }

        // Menyimpan data pemesanan dalam session
        $_SESSION['pesanan'] = [
            'nama' => $nama,
            'tanggal' => $tanggal,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'lapangan' => $lapangan,
            'total_harga' => $total_harga, // Menyimpan total harga
            'ktm_file' => $ktm_file // Menyimpan nama file KTM
        ];

        $_SESSION['success_message'] = "Pemesanan berhasil!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyewaan - Lampung Futsal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #C9E6F0;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styling */
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

        /* Form Styling */
        .form-control {
            margin-bottom: 10px;
        }

        /* Table Styling */
        .table-bordered {
            margin-top: 20px;
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
                    <li class="nav-item"><a class="nav-link active" href="penyewaan.php">Penyewaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="layanan.php">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="bukti.php">Bukti Pembayaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <h2>Penyewaan Lapangan</h2>
        <p>Kami menyediakan lapangan futsal berkualitas tinggi dengan fasilitas terbaik di Lampung.</p>
        <ul>
            <li>Harga per jam: Rp 170.000</li>
            <li>Harga paket 5 jam: Rp 700.000</li>
            <li>Diskon 20% khusus untuk mahasiswa menggunakan KTM.</li>
        </ul>

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

        <!-- Form Pemesanan -->
        <form class="mt-3" action="" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Pemesan:</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
            <label for="tanggal">Tanggal Sewa:</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            <label for="jam_mulai">Jam Mulai:</label>
            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
            <label for="jam_selesai">Jam Selesai:</label>
            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
            <label for="lapangan">Pilih Lapangan:</label>
            <select class="form-control" id="lapangan" name="lapangan" required>
                <option value="A">Lapangan A</option>
                <option value="B">Lapangan B</option>
            </select>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="ktm" name="ktm">
                <label class="form-check-label" for="ktm">Saya adalah mahasiswa dan memiliki KTM.</label>
            </div>
            <div id="ktm-upload" style="display: none;">
                <label for="ktm_file">Unggah Foto KTM:</label>
                <input type="file" class="form-control" id="ktm_file" name="ktm_file" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Pesan Sekarang</button>
        </form>

        <!-- Tampilkan data pemesanan jika ada -->
        <?php if (isset($_SESSION['pesanan'])): ?>
            <div class="mt-4">
                <h4>Data Pemesan:</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Pemesan</th>
                        <th>Tanggal Sewa</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Lapangan</th>
                        <th>Total Pembayaran</th>
                        <th>Foto KTM</th>
                    </tr>
                    <tr>
                        <td><?php echo $_SESSION['pesanan']['nama']; ?></td>
                        <td><?php echo $_SESSION['pesanan']['tanggal']; ?></td>
                        <td><?php echo $_SESSION['pesanan']['jam_mulai']; ?></td>
                        <td><?php echo $_SESSION['pesanan']['jam_selesai']; ?></td>
                        <td><?php echo $_SESSION['pesanan']['lapangan']; ?></td>
                        <td>Rp <?php echo number_format($_SESSION['pesanan']['total_harga'], 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($_SESSION['pesanan']['ktm_file']): ?>
                                <img src="uploads/ktm/<?php echo $_SESSION['pesanan']['ktm_file']; ?>" alt="Foto KTM" width="100">
                            <?php else: ?>
                                Tidak ada foto KTM.
                            <?php endif; ?>
                        <td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <a href='edit_penyewaan.php?id=" . $data['id'] . "'>Edit</a></td>";

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menampilkan input upload KTM jika checkbox "Saya mahasiswa" dicentang
        document.getElementById('ktm').addEventListener('change', function() {
            document.getElementById('ktm-upload').style.display = this.checked ? 'block' : 'none';
        });
    </script>
</body>
</html>
