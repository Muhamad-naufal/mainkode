<!-- hapus project -->
<?php
// Koneksi ke database
include '../connection/db.php';

// Cek apakah parameter id ada
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query hapus project
    $query = "DELETE FROM projects WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirect ke halaman daftar project setelah berhasil hapus
        header("Location: ../../admin/page/project_index.php");
        exit();
    } else {
        echo "Gagal menghapus project.";
    }

    unset($stmt);
} else {
    echo "ID project tidak ditemukan.";
}
?>