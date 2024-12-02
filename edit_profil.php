<?php
session_start();
include 'connect.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Proses pengubahan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update data pengguna
    $updateQuery = "UPDATE users SET email = '$email' WHERE username = '$username'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Profil berhasil diperbarui!');</script>";
        header("Location: profil.php");
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui profil.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
</head>
<body>
    <h2>Edit Profil</h2>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="profil.php">Kembali</a>
</body>
</html>
