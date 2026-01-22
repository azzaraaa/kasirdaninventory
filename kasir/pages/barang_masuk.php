<?php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$produk = $conn->query("SELECT * FROM produk");

$masuk = $conn->query("
    SELECT 
        barang_masuk.*, 
        produk.nama_produk 
    FROM barang_masuk 
    JOIN produk ON barang_masuk.id_produk = produk.id_produk 
    ORDER BY barang_masuk.tanggal DESC
");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang Masuk</title>
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

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        h2 {
            margin-top: 0;
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
</head>
<body>

<header>
    <h1>Barang Masuk</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
</header>

<div class="container">
    <h2>Tambah Barang Masuk</h2>
    <form method="POST" action="../api/masuk_process.php">
        <select name="id_produk" required>
            <?php while ($row = $produk->fetch_assoc()): ?>
                <option value="<?= $row['id_produk']; ?>"><?= $row['nama_produk']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="jumlah" placeholder="Jumlah" required>
        <input type="text" name="keterangan" placeholder="Keterangan">
        <button type="submit">Simpan</button>
    </form>

    <h2>Riwayat Barang Masuk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while ($row = $masuk->fetch_assoc()): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td><?= $row['keterangan']; ?></td>
                <td><?= $row['tanggal']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
