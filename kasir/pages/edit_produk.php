<?php
include "../config/db.php";

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan");
}

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM produk WHERE id_produk = $id")->fetch_assoc();

if (!$data) {
    die("Produk tidak ditemukan");
}
?>

<h2>Edit Produk</h2>

<form method="post">
    <label>Nama Produk</label><br>
    <input type="text" name="nama" value="<?= $data['nama_produk']; ?>" required><br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" value="<?= $data['harga']; ?>" required><br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" value="<?= $data['stok']; ?>" required><br><br>

    <button type="submit" name="simpan">Simpan Perubahan</button>
    <a href="produk.php">Batal</a>
</form>

<?php
if (isset($_POST['simpan'])) {
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    $conn->query("
        UPDATE produk 
        SET nama_produk='$nama', harga='$harga', stok='$stok'
        WHERE id_produk=$id
    ");

    header("Location: produk.php");
    exit;
}
