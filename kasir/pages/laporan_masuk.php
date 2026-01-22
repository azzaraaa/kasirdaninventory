<?php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Ambil data barang masuk dari DB
$data = $conn->query("SELECT barang_masuk.*, produk.nama 
                      FROM barang_masuk 
                      JOIN produk ON barang_masuk.id_produk = produk.id 
                      ORDER BY barang_masuk.tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Masuk</title>
</head>
<body>
    <h2>Laporan Barang Masuk</h2>
    <a href="dashboard.php">← Kembali ke Dashboard</a> |
    <a href="#" onclick="window.print()">🖨️ Cetak</a>
    <hr>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
        </tr>
        <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['jumlah']; ?></td>
            <td><?= $row['keterangan']; ?></td>
            <td><?= $row['tanggal']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
