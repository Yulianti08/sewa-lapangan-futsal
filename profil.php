<?php
session_start();
include 'connect.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari database
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Jika pengguna tidak ditemukan
if (!$user) {
    echo "<script>alert('Pengguna tidak ditemukan.');</script>";
    session_destroy();
    header("Location: login.php");
    exit();
}

// Proses ganti foto profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES['profile_picture']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Validasi tipe file
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFilePath)) {
            if ($user['profile_picture'] && $user['profile_picture'] !== 'default.jpg') {
                unlink($user['profile_picture']); // Hapus foto lama
            }
            $updateQuery = "UPDATE users SET profile_picture = '$targetFilePath' WHERE username = '$username'";
            if (mysqli_query($conn, $updateQuery)) {
                header("Location: profil.php");
                exit();
            } else {
                echo "<script>alert('Gagal memperbarui foto profil di database.');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengunggah file.');</script>";
        }
    } else {
        echo "<script>alert('Format file tidak didukung. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
    }
}

// Proses hapus foto profil
if (isset($_POST['delete_photo'])) {
    if ($user['profile_picture'] && $user['profile_picture'] !== 'default.jpg') {
        unlink($user['profile_picture']); // Hapus file foto dari server
    }
    $updateQuery = "UPDATE users SET profile_picture = 'default.jpg' WHERE username = '$username'";
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: profil.php");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus foto profil.');</script>";
    }
}
?>
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
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
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 20px auto;
            border: 2px solid #3498db;
            cursor: pointer;
        }
        .profile-container {
            position: relative;
            display: inline-block;
        }
        .change-pic-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 40px;
            height: 40px;
            background-color: #3498db;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            color: white;
            font-size: 24px;
            border: none;
        }
        .change-pic-btn:hover {
            background-color: #2980b9;
        }
        .change-pic-text {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #3498db;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">Lampung Futsal</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="penyewaan.php">Penyewaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="layanan.php">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="bukti.php">Bukti Pembayaran</a></li>
                    <li class="nav-item"><a class="nav-link active" href="profil.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

      <!-- Profile -->
      <div class="container mt-5">
        <div class="profile-container">
            <div class="position-relative">
                <img src="<?php echo $user['profile_picture'] ?: 'default.jpg'; ?>" alt="Foto Profil" class="profile-pic">
                <button class="change-pic-btn" data-bs-toggle="modal" data-bs-target="#profileModal">+</button>
            </div>
            <h3><?php echo htmlspecialchars($user['username']); ?></h3>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="file" name="profile_picture" class="form-control mb-3">
                        <button type="submit" class="btn btn-primary w-100">Unggah</button>
                    </form>
                    <form method="POST">
                        <button type="submit" name="delete_photo" class="btn btn-danger w-100 mt-3">Hapus Foto</button>
                    </form>
                </div>
            </div>
            </div>
        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
        <p><?php echo htmlspecialchars($user['email']); ?></p>
        <div class="btn-container">
            <a href="ganti_password.php" class="btn" style="background-color: #e74c3c;">Ganti password</a>
        </div>
    </div>
            <a href="ganti_password.php" class="btn" style="background-color: #e74c3c;">Ganti password</a>
        </div>
    </div>
    
    <!-- Modal Foto Profil -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="<?php echo $user['profile_picture'] ?: 'default.jpg'; ?>" alt="Foto Profil Besar" class="w-100">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
