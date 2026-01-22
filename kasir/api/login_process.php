<?php
session_start();
include '../config/db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $_SESSION['admin'] = $username;
    header("Location: ../pages/dashboard.php");
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: ../pages/login.php");
}
?>
