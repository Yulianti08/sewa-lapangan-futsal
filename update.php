<?php
session_start();
include 'connect.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Harap login terlebih dahulu!'); window.location='login.php';</script>";
    exit();
}

// Ambil data user berdasarkan sesi
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('Data user tidak ditemukan!'); window.location='login.php';</script>";
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = $_POST['password'];

    // Hash password baru jika diisi
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $user['password']; // Gunakan password lama jika tidak diubah
    }

    // Update data user
    $update_query = "UPDATE users SET username = ?, password = ? WHERE username = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sss", $new_username, $hashed_password, $username);

    if ($stmt->execute()) {
        // Perbarui session dengan username baru
        $_SESSION['username'] = $new_username;
        echo "<script>alert('Data berhasil diperbarui!'); window.location='home.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Akun</title>
    <style>
        /* Styling sama dengan halaman login */
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #2C3E50;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #ecf0f1;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            color: #ecf0f1;
            font-size: 16px;
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #bdc3c7;
            font-size: 16px;
            background-color: #34495e;
            color: #ecf0f1;
        }

        input:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        p {
            text-align: center;
            margin-top: 15px;
            color: #ecf0f1;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Akun</h2>
        <form method="POST" action="">
            <label for="username">Username Baru:</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']); ?>" required>

            <label for="password">Password Baru (Opsional):</label>
            <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin diubah">

            <button type="submit">Simpan Perubahan</button>
        </form>
        <p><a href="home.php">Kembali ke Beranda</a></p>
    </div>
</body>
</html>
