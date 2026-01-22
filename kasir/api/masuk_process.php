<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk  = $_POST['id_produk'];
    $jumlah     = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    // Coba insert dulu
    $insert = $conn->query("INSERT INTO barang_masuk (id_produk, jumlah, keterangan) 
                            VALUES ('$id_produk', '$jumlah', '$keterangan')");

    if (!$insert) {
        die("Gagal insert ke barang_masuk: " . $conn->error);
    }

    // Update stok
    $update = $conn->query("UPDATE produk SET stok = stok + $jumlah WHERE id = $id_produk");

    if (!$update) {
        die("Gagal update stok: " . $conn->error);
    }

    header("Location: ../pages/barang_masuk.php");
    exit;
} else {
    echo "Metode tidak diizinkan.";
}
