<?php
session_start(); // Memulai sesi

// Menghancurkan sesi
if (isset($_SESSION['username'])) {
    session_unset(); // Hapus semua data sesi
    session_destroy(); // Hancurkan sesi
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        /* Global Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #34495e;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            color: #ecf0f1;
            margin-bottom: 20px;
        }

        p {
            color: #ecf0f1;
            font-size: 16px;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Anda Telah Logout</h2>
        <p>Terima kasih telah menggunakan layanan kami. Silakan login kembali jika ingin mengakses sistem.</p>
        <a href="index.php">Kembali ke Halaman Login</a>
    </div>
</body>
</html>
