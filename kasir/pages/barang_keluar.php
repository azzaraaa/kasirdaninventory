<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Ambil data produk
$produk = $conn->query("SELECT * FROM produk");

// Ambil data barang keluar + nama produk
$keluar = $conn->query("
    SELECT 
        barang_keluar.*, 
        produk.nama_produk 
    FROM barang_keluar
    JOIN produk ON barang_keluar.id_produk = produk.id_produk
    ORDER BY barang_keluar.tanggal DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #0f112b, #1f1f3e);
            color: #fff;
        }

        header {
            background: linear-gradient(to right, #3b82f6, #9333ea);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.6em;
        }

        nav a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        form input, form select, form button {
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            border-radius: 6px;
            border: none;
        }

        form button {
            background: #3b82f6;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: left;
        }

        th {
            background-color: rgba(255, 255, 255, 0.05);
        }
    </style>

    <script>
        function hitungTotal() {
            const produk = document.getElementById("produk");
            const harga  = produk.options[produk.selectedIndex].dataset.harga;
            const jumlah = document.getElementById("jumlah").value || 0;

            const total = harga * jumlah;
            document.getElementById("total").value = total;

            hitungKembali();
        }

        function hitungKembali() {
            const total = document.getElementById("total").value || 0;
            const bayar = document.getElementById("bayar").value || 0;
            document.getElementById("kembali").value = bayar - total;
        }
    </script>
</head>

<body>

<header>
    <h1>Transaksi Penjualan</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
</header>

<div class="container">
    <h2>Input Transaksi</h2>

    <form method="POST" action="../api/keluar_process.php">
        <select name="id_produk" id="produk" onchange="hitungTotal()" required>
            <?php while ($row = $produk->fetch_assoc()): ?>
                <option 
                    value="<?= $row['id_produk']; ?>" 
                    data-harga="<?= $row['harga']; ?>">
                    <?= $row['nama_produk']; ?> (Stok: <?= $row['stok']; ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah Beli" oninput="hitungTotal()" required>
        <input type="number" name="total" id="total" placeholder="Total Harga" readonly>
        <input type="number" name="bayar" id="bayar" placeholder="Uang Bayar" oninput="hitungKembali()" required>
        <input type="number" name="kembali" id="kembali" placeholder="Kembalian" readonly>

        <button type="submit">Simpan Transaksi</button>
    </form>

    <h2>Riwayat Penjualan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembali</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $keluar->fetch_assoc()): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td>Rp <?= number_format($row['total']); ?></td>
                <td>Rp <?= number_format($row['bayar']); ?></td>
                <td>Rp <?= number_format($row['kembali']); ?></td>
                <td><?= $row['tanggal']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
