<?php
include '../config/db.php';

header('Content-Type: application/json');

if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
    
    // Hindari SQL Injection
    $kode = $conn->real_escape_string($kode);

    $result = $conn->query("SELECT * FROM produk WHERE kode = '$kode'");

    if ($result && $result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
