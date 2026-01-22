<?php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$produk = $conn->query("SELECT * FROM produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: left;
        }

        th {
            background-color: rgba(255, 255, 255, 0.05);
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

        a {
            color: #3b82f6;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<header>
    <h1>Manajemen Produk</h1>
    <nav>
        <a href="?tambah">Tambah Produk</a>
    </nav>
</header>

<div class="container">
<?php if (isset($_GET['tambah'])): ?>
    <h2>Tambah Produk</h2>
     <a href="dashboard.php">← Kembali ke Dashboard</a>
    <form method="POST" action="../api/produk_process.php">
        <input type="hidden" name="aksi" value="tambah">
        <input type="text" name="kode" placeholder="Kode Produk (unik)" required>
        <input type="text" name="nama" placeholder="Nama Produk" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <input type="number" name="stok" placeholder="Stok" required>
        <button type="submit">Simpan</button>
    </form>

<?php elseif (isset($_GET['edit'])):
    $id = $_GET['edit'];
    $data = $conn->query("SELECT * FROM produk WHERE id=$id")->fetch_assoc();
?>
    <h2>Edit Produk</h2>
    <form method="POST" action="../api/produk_process.php">
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="id" value="<?= $data['id']; ?>">
        <input type="text" name="kode" value="<?= $data['kode']; ?>" required>
        <input type="text" name="nama" value="<?= $data['nama']; ?>" required>
        <input type="number" name="harga" value="<?= $data['harga']; ?>" required>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" required>
        <button type="submit">Update</button>
    </form>

<?php else: ?>
    <h2>Daftar Produk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = $produk->fetch_assoc()): ?>
            <tr>
                <td><?= $no++; ?></td>
               <td><?= $row['id_produk']; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td>Rp<?= number_format($row['harga']); ?></td>
                <td><?= $row['stok']; ?></td>
               <td>
                <a href="edit_produk.php?id=<?= $row['id_produk']; ?>">Edit</a> |
                <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>"
                    onclick="return confirm('Hapus produk ini?')">Hapus</a>
</td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>

</body>
</html>
