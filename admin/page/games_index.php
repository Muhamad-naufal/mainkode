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
$sql = "SELECT g.*, c.name AS category_name 
        FROM games g 
        LEFT JOIN categories c ON g.category_id = c.id 
        WHERE 1";

// Parameter pencarian
$params = [];
if ($search) {
    $sql .= " AND (g.title LIKE :search OR c.name LIKE :search)";
    $params['search'] = "%$search%";
}

// Total data
$countStmt = $pdo->prepare(str_replace("g.*", "COUNT(*) as total", $sql));
$countStmt->execute($params);
$total = $countStmt->fetch()['total'];
$total_pages = ceil($total / $limit);

// Query data games
$sql .= " ORDER BY g.created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$games = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Game - ENGaming</title>
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
        <h1 class="text-xl font-bold text-white">Kelola Game</h1>
        <button id="toggleSidebar" class="text-white text-2xl"><i class="bi bi-list"></i></button>
    </nav>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 space-y-6">
            <!-- Header & Tombol -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Kelola Game</h1>
                <a href="game_tambah.php" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Game
                </a>
            </div>

            <!-- Filter -->
            <form class="flex flex-wrap gap-4 items-center" method="GET">
                <input type="text" name="search" placeholder="Cari judul atau kategori..."
                    value="<?= htmlspecialchars($search) ?>"
                    class="px-4 py-2 rounded bg-white/10 border border-white/20 text-sm text-white focus:ring-2 focus:ring-blue-500">
            </form>

            <!-- Tabel Games -->
            <div class="overflow-x-auto bg-white/5 p-5 rounded-xl shadow-md">
                <table class="w-full text-sm table-auto">
                    <thead class="text-left text-gray-400 border-b border-white/10">
                        <tr>
                            <th class="py-2">#</th>
                            <th>Judul</th>
                            <th>Cover</th>
                            <th>Ukuran File</th>
                            <th>Exclusive</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        <?php foreach ($games as $i => $game): ?>
                            <tr class="hover:bg-white/5 transition">
                                <td class="py-2"><?= $offset + $i + 1 ?></td>
                                <td class="font-medium"><?= htmlspecialchars($game['title']) ?></td>
                                <td>
                                    <?php if (!empty($game['cover_image'])): ?>
                                        <img src="../../backend/uploads/games/<?= htmlspecialchars($game['cover_image']) ?>" alt="" class="h-12 w-12 object-cover rounded">
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($game['file_size'] ?? '-') ?> GB</td>
                                <td>
                                    <?php if ($game['is_exclusive']): ?>
                                        <span class="text-green-400 font-bold">Ya</span>
                                    <?php else: ?>
                                        <span class="text-gray-400">Tidak</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d M Y', strtotime($game['created_at'])) ?></td>
                                <td>
                                    <a href="game_edit.php?id=<?= $game['id'] ?>" class="text-yellow-400 hover:underline text-xs">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a> |
                                    <a href="../../backend/admin/game_hapus.php?id=<?= $game['id'] ?>"
                                        class="text-red-400 hover:underline text-xs"
                                        onclick="return confirm('Yakin hapus game ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($games) === 0): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-gray-400 italic">Tidak ada game ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            <?php if ($total_pages > 1): ?>
                <div class="flex justify-center gap-2 mt-4">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"
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