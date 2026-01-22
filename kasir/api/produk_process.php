<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['aksi'] === 'tambah') {
        $kode  = $_POST['kode'];
        $nama  = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $stok  = $_POST['stok'];

        $conn->query("INSERT INTO produk (kode, nama, harga, stok) VALUES ('$kode', '$nama', '$harga', '$stok')");
        header("Location: ../pages/produk.php");
        exit;

    } elseif ($_POST['aksi'] === 'edit') {
        $id    = $_POST['id_produk'];
        $kode  = $_POST['kode'];
        $nama  = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $stok  = $_POST['stok'];

        $conn->query("UPDATE produk SET kode='$kode', nama='$nama', harga='$harga', stok='$stok' WHERE id=$id");
        header("Location: ../pages/produk.php");
        exit;
    }

} elseif (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    // Hapus data transaksi terkait dulu (jika ada)
    $conn->query("DELETE FROM barang_keluar WHERE id_produk = $id");
    $conn->query("DELETE FROM barang_masuk WHERE id_produk = $id");

    // Hapus produk
    $conn->query("DELETE FROM produk WHERE id = $id");

    header("Location: ../pages/produk.php");
    exit;
}
