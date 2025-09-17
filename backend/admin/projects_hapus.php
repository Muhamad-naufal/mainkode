<?php
// Koneksi ke database
include '../connection/db.php';

// Cek apakah parameter id ada
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data project untuk cek gambar
    $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($project) {
        // Hapus file gambar kalau ada
        if (!empty($project['image'])) {
            $filePath = __DIR__ . "/../uploads/projects/" . $project['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data dari DB
        $del = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        if ($del->execute([$id])) {
            header("Location: ../../admin/page/project_index.php");
            exit();
        } else {
            echo "Gagal menghapus project.";
        }
    } else {
        echo "Project tidak ditemukan.";
    }
} else {
    echo "ID project tidak ditemukan.";
}
