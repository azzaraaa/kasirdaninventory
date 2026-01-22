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
    <title>Scan Produk</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: rgba(255,255,255,0.05);
            border-radius: 12px;
        }

        #reader {
            width: 100%;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            color: #fff;
        }

        th, td {
            padding: 10px;
            border: 1px solid rgba(255,255,255,0.2);
            text-align: left;
        }

        th {
            background-color: #3b82f6;
        }
    </style>
</head>
<body>

<header>
    <h1>Scan Produk</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
</header>

<div class="container">
    <div id="reader"></div>
    <div id="result"></div>
</div>

<!-- Beep sound -->
<audio id="beep" src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg" preload="auto"></audio>

<script>
    function showProduk(produk) {
        document.getElementById('result').innerHTML = `
            <h3>Produk Ditemukan:</h3>
            <table>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
                <tr>
                    <td>${produk.kode}</td>
                    <td>${produk.nama}</td>
                    <td>Rp${parseInt(produk.harga).toLocaleString()}</td>
                    <td>${produk.stok}</td>
                </tr>
            </table>
        `;
    }

    function startScanner() {
        let scanner = new Html5Qrcode("reader");
        scanner.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            async (decodedText) => {
                scanner.stop();

                // 🔊 Play beep
                document.getElementById("beep").play();

                // Fetch produk by kode
                let response = await fetch(`../api/get_produk.php?kode=${decodedText}`);
                let produk = await response.json();

                if (produk) {
                    showProduk(produk);
                } else {
                    document.getElementById('result').innerHTML = "<p>Produk tidak ditemukan.</p>";
                }

                // Restart scanner setelah 3 detik
                setTimeout(() => {
                    document.getElementById('result').innerHTML = "";
                    startScanner();
                }, 3000);
            },
            (err) => {
                console.warn("Scan error", err);
            }
        );
    }

    startScanner();
</script>

</body>
</html>
