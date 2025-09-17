<?php
session_start();
include '../connection/db.php';

// Ambil data dari form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Query cek user
$sql = "SELECT id, username, password FROM admin WHERE username = :username AND password = :password LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userData) {
    // Login sukses
    $_SESSION['admin_id'] = $userData['id'];
    $_SESSION['admin_username'] = $userData['username'];
    $_SESSION['admin'] = true;

    header("Location: ../../admin/page/dashboard.php");
    exit;
} else {
    // Login gagal
    echo "<script>alert('Username atau password salah!'); window.location.href='../../admin/login/login.php';</script>";
}
