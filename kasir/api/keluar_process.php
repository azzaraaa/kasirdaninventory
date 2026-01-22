<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php';

$id_produk = $_POST['id_produk'];
$jumlah    = $_POST['jumlah'];
$bayar     = $_POST['bayar'];

// Ambil harga produk
$data = $conn->query("SELECT harga FROM produk WHERE id_produk = $id_produk")->fetch_assoc();
$harga = $data['harga'];

// Hitung total & kembalian
$total   = $jumlah * $harga;
$kembali = $bayar - $total;

// Simpan transaksi
$conn->query("
    INSERT INTO barang_keluar 
    (id_produk, jumlah, harga, total, bayar, kembali, tanggal)
    VALUES 
    ($id_produk, $jumlah, $harga, $total, $bayar, $kembali, NOW())
");

// Kurangi stok
$conn->query("
    UPDATE produk 
    SET stok = stok - $jumlah 
    WHERE id_produk = $id_produk
");

header("Location: ../pages/barang_keluar.php");
exit;
