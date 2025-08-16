<?php
// tag_index.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';
$tags = $pdo->query("SELECT * FROM tag ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Tag</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <a href="blog_index.php">
                <h1 class="text-2xl font-bold">Daftar Tag</h1>
            </a>
            <a href="tag_tambah.php" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white">+ Tambah Tag</a>
        </div>
        <table class="w-full text-left border border-white/10 rounded overflow-hidden">
            <thead class="bg-white/10">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Tag</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tags as $i => $tag): ?>
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-2"><?= $i + 1 ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($tag['nama']) ?></td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="tag_edit.php?id=<?= $tag['id'] ?>" class="text-yellow-400 hover:underline">Edit</a>
                            <a href="../../backend/admin/tag_hapus.php?id=<?= $tag['id'] ?>" onclick="return confirm('Yakin ingin menghapus tag ini?')" class="text-red-500 hover:underline">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>