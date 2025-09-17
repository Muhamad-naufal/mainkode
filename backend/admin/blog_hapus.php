<?php
require_once '../connection/db.php';

if (!isset($_GET['id'])) die('ID tidak ditemukan');
$id = (int) $_GET['id'];

// Ambil data blog untuk cek gambar
$stmt = $pdo->prepare("SELECT gambar FROM blog WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if ($blog) {
    // Hapus file gambar jika ada
    if (!empty($blog['gambar'])) {
        $filePath = __DIR__ . "/../uploads/blog/" . $blog['gambar'];
        // Cek apakah file ada sebelum menghapus
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Hapus data blog
    $del = $pdo->prepare("DELETE FROM blog WHERE id = ?");
    $del->execute([$id]);
}

header("Location: ../../admin/page/blog_index.php");
exit;
