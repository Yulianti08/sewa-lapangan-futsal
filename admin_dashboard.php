<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0a0925;
            color: white;
            padding: 20px;
        }
        header {
            text-align: center;
            background-color: #222;
            padding: 10px;
            border-radius: 10px;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 10px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="manage_users.php">Kelola Pengguna</a></li>
                <li><a href="manage_reservations.php">Kelola Penyewaan</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <p>Selamat datang, Admin <?php echo $_SESSION['username']; ?>!</p>
        <p>Gunakan menu di atas untuk mengelola aplikasi.</p>
    </main>
</body>
</html>
