<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaPenyewa = htmlspecialchars($_POST['namaPenyewa']);
    $targetDir = "uploads/";
    $fileName = basename($_FILES['buktiFile']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($_FILES['buktiFile']['tmp_name'], $targetFilePath)) {
        echo "<script>
            alert('Bukti pembayaran berhasil diunggah!');
            window.location.href='bukti.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengunggah bukti pembayaran. Silakan coba lagi.');
            window.location.href='bukti.php';
        </script>";
    }
}
?>
