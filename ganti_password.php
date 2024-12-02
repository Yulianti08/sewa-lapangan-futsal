<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['change_password'])) {
    $username = $_SESSION['username'];
    $oldPassword = $_POST['old_password'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Verifikasi password lama
    $query = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($oldPassword, $user['password'])) {
        // Update password
        $updateQuery = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
        mysqli_query($conn, $updateQuery);
        echo "<script>alert('Password berhasil diubah!'); window.location.href='profil.php';</script>";
    } else {
        echo "<script>alert('Password lama salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 40%;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
        }

        label {
            display: block;
            margin: 15px 0 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ganti Password</h2>
        <form method="POST">
            <label for="old_password">Password Lama:</label>
            <input type="password" id="old_password" name="old_password" required>

            <label for="new_password">Password Baru:</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit" name="change_password">Simpan Password</button>
        </form>
        <button onclick="window.location.href='profil.php'" style="margin-top: 20px;">Kembali</button>
    </div>
</body>
</html>
