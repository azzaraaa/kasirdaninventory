<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #0f112b, #1f1f3e);
            color: #ffffff;
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
            font-size: 1.8em;
            font-weight: 600;
        }

        nav a {
            color: #ffffff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .container {
            max-width: 1000px;
            margin: 60px auto;
            padding: 20px;
            text-align: center;
        }

        .container p {
            font-size: 1.2em;
        }

        footer {
            text-align: center;
            margin-top: 80px;
            padding: 20px;
            font-size: 0.9em;
            color: #aaa;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            nav {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            nav a {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>KasirApp</h1>
    <nav>
        <a href="produk.php">Produk</a>
        <a href="barang_masuk.php">Barang Masuk</a>
        <a href="barang_keluar.php">Transaksi</a>
        <a href="laporan_barang_masuk.php">Laporan</a>
        <a href="scan_produk.php">Scan Produk</a>
       <a href="#" onclick="confirmLogout()">Logout</a>

<!-- Modal Konfirmasi -->
<div id="logoutModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.5);">
    <div style="background:#1f1f3e; padding:30px; border-radius:12px; width:300px; margin:150px auto; text-align:center; color:white;">
        <p>Apakah Anda yakin ingin keluar?</p>
        <button onclick="window.location.href='../logout.php'" style="background:#ef4444; border:none; padding:10px 20px; margin-right:10px; border-radius:8px; color:white;">Ya</button>
        <button onclick="document.getElementById('logoutModal').style.display='none'" style="background:#3b82f6; border:none; padding:10px 20px; border-radius:8px; color:white;">Batal</button>
    </div>
</div>

<script>
    function confirmLogout() {
        document.getElementById('logoutModal').style.display = 'block';
    }
</script>

    </nav>
</header>

<div class="container">
    <p>Halo, <strong><?= $_SESSION['admin']; ?></strong>! Selamat datang di dashboard kasir kamu.</p>
</div>

<footer>
    &copy; <?= date('Y'); ?> KasirApp. Dibuat dengan sederhana dan fungsional.
</footer>

</body>
</html>
