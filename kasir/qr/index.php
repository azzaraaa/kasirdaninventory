<?php
include '../config/db.php';

$produk = null;
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
    $produk = $conn->query("SELECT * FROM produk WHERE kode = '$kode'")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    <h2>Scan QR Code Produk</h2>
    <a href="../pages/dashboard.php">← Kembali</a>
    <div id="reader" style="width: 300px;"></div>

    <script>
        const scanner = new Html5Qrcode("reader");
        scanner.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            qrCodeMessage => {
                window.location.href = "?kode=" + qrCodeMessage;
                scanner.stop();
            },
            errorMessage => {
                // ignore scan errors
            }
        );
    </script>

    <?php if ($produk): ?>
        <hr>
        <h3>Detail Produk</h3>
        <p><strong>Kode:</strong> <?= $produk['kode']; ?></p>
        <p><strong>Nama:</strong> <?= $produk['nama']; ?></p>
        <p><strong>Harga:</strong> Rp<?= number_format($produk['harga']); ?></p>
        <p><strong>Stok:</strong> <?= $produk['stok']; ?></p>
    <?php endif; ?>
</body>
</html>
