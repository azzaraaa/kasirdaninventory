<?php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$data = $conn->query("
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
    <title>Laporan Barang Masuk</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(180deg, #0f112b, #1e1f40);
            color: #fff;
        }

        header {
            padding: 40px 20px 20px;
            text-align: center;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            color: #fff;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.1);
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .actions a,
        .actions button {
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .actions a:hover,
        .actions button:hover {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
        }

        th {
            background-color: rgba(255, 255, 255, 0.05);
            font-weight: 600;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.07);
        }

        footer {
            text-align: center;
            margin-top: 60px;
            padding: 20px;
            font-size: 0.9em;
            color: #aaa;
        }
    </style>
</head>
<body>

    <header>
        <h1>Laporan Barang Masuk</h1>
        <p>Riwayat stok masuk ke dalam sistem</p>
    </header>

    <div class="container">
        <div class="actions">
            <a href="dashboard.php">← Kembali ke Dashboard</a>
            <button onclick="window.print()">🖨️ Cetak Laporan</button>
        </div>

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
                <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
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

    <footer>
        &copy; <?= date('Y'); ?> KasirApp. All rights reserved.
    </footer>

</body>
</html>
