<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login/login.php");
    exit;
}
require_once '../../backend/connection/db.php';



// Parameter GET
$search = $_GET['search'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;

// Query dasar
$sql = "SELECT * FROM blog WHERE 1";

// Parameter pencarian
$params = [];

if ($search) {
    $sql .= " AND (judul LIKE :search OR slug LIKE :search)";
    $params['search'] = "%$search%";
}

// Total data
$countStmt = $pdo->prepare(str_replace("*", "COUNT(*) as total", $sql));
$countStmt->execute($params);
$total = $countStmt->fetch()['total'];
$total_pages = ceil($total / $limit);

// Query data blog
$sql .= " ORDER BY dibuat_pada DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$blogs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Blog - Main Kode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 15px #3b82f6;
        }
    </style>
</head>

<body class="bg-gray-950 text-white min-h-screen flex flex-col">
    <!-- Navbar Mobile -->
    <nav class="bg-gray-900 border-b border-white/10 p-4 flex justify-between items-center md:hidden">
        <h1 class="text-xl font-bold text-white">Kelola Blog</h1>
        <button id="toggleSidebar" class="text-white text-2xl"><i class="bi bi-list"></i></button>
    </nav>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 space-y-6">
            <!-- Header & Tombol -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Kelola Blog</h1>
                <a href="blog_tambah.php" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-sm"><i class="bi bi-plus-lg"></i> Tambah Blog</a>
                <a href="tag_index.php" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-sm">Lihat Tag</a>
            </div>

            <!-- Filter -->
            <form class="flex flex-wrap gap-4 items-center" method="GET">
                <input type="text" name="search" placeholder="Cari judul atau slug..." value="<?= htmlspecialchars($search) ?>"
                    class="px-4 py-2 rounded bg-white/10 border border-white/20 text-sm text-white focus:ring-2 focus:ring-blue-500">
            </form>

            <!-- Tabel Blog -->
            <div class="overflow-x-auto bg-white/5 p-5 rounded-xl shadow-md">
                <table class="w-full text-sm table-auto">
                    <thead class="text-left text-gray-400 border-b border-white/10">
                        <tr>
                            <th class="py-2">#</th>
                            <th>Judul</th>
                            <th>Slug</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        <?php foreach ($blogs as $i => $blog): ?>
                            <tr class="hover:bg-white/5 transition">
                                <td class="py-2"><?= $offset + $i + 1 ?></td>
                                <td class="font-medium"><?= htmlspecialchars($blog['judul']) ?></td>
                                <td class="text-gray-400"><?= htmlspecialchars($blog['slug']) ?></td>
                                <td><?= date('d M Y', strtotime($blog['dibuat_pada'])) ?></td>
                                <td>
                                    <a href="blog_edit.php?id=<?= $blog['id'] ?>" class="text-yellow-400 hover:underline text-xs"><i class="bi bi-pencil-square"></i> Edit</a> |
                                    <a href="../../backend/admin/blog_hapus.php?id=<?= $blog['id'] ?>" class="text-red-400 hover:underline text-xs" onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($blogs) === 0): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400 italic">Tidak ada blog ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            <?php if ($total_pages > 1): ?>
                <div class="flex justify-center gap-2 mt-4">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?search=<?= urlencode($search) ?>&tag_id=<?= $tag_id ?>&page=<?= $i ?>"
                            class="px-3 py-1 rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white/10 text-white hover:bg-blue-700' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        document.getElementById('toggleSidebar')?.addEventListener('click', () => {
            document.getElementById('sidebar')?.classList.toggle('hidden');
        });
    </script>
</body>

</html>