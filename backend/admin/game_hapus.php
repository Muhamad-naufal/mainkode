<?php
// hapus_game.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

include '../connection/db.php'; // sesuaikan path jika perlu

if (!isset($_GET['id'])) {
    echo "ID game tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);

try {
    // 1) Ambil dulu data game (cover) sebelum dihapus
    $stmt = $pdo->prepare("SELECT cover_image FROM games WHERE id = ?");
    $stmt->execute([$id]);
    $game = $stmt->fetch();

    if (!$game) {
        echo "Game tidak ditemukan.";
        exit;
    }

    $cover = $game['cover_image']; // nama file (misal: 162343_cover.jpg) atau bisa kosong

    // 2) Hapus record di database
    $del = $pdo->prepare("DELETE FROM games WHERE id = ?");
    $del->execute([$id]);

    // 3) Hapus file fisik (jika ada dan valid)
    if (!empty($cover)) {
        // Tentukan folder uploads (sesuaikan relatif terhadap lokasi script ini)
        $uploadsDir = realpath(__DIR__ . '/../../backend/uploads/games');

        if ($uploadsDir !== false) {
            // gunakan basename untuk mencegah path traversal
            $filename = basename($cover);
            $filePath = $uploadsDir . DIRECTORY_SEPARATOR . $filename;

            // Pastikan file benar-benar ada dan berada di dalam uploadsDir
            if (is_file($filePath)) {
                $real = realpath($filePath);
                if ($real !== false && strpos($real, $uploadsDir) === 0) {
                    if (!@unlink($real)) {
                        // Logging: gagal hapus file (cek permission)
                        error_log("Gagal menghapus file cover: {$real}");
                    }
                } else {
                    error_log("File cover berada di luar direktori uploads: {$filePath}");
                }
            } else {
                // file tidak ditemukan (mungkin sudah terhapus manual)
                error_log("File cover tidak ditemukan: {$filePath}");
            }
        } else {
            error_log("Direktori uploads tidak ditemukan: " . __DIR__ . '/../../backend/uploads/games');
        }
    }

    // Redirect kembali ke halaman daftar game (sesuaikan path)
    header("Location: ../../admin/page/games_index.php");
    exit;
} catch (Exception $e) {
    error_log("Error hapus game: " . $e->getMessage());
    echo "Terjadi kesalahan saat menghapus game.";
    exit;
}
