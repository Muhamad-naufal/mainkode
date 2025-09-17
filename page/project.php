<?php
include '../backend/connection/db.php';

// Ambil parameter search & pagination
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$itemsPerPage = 6;
$offset = ($page - 1) * $itemsPerPage;

// Query data
$where = "";
$params = [];
if ($search) {
    $where = "WHERE title LIKE :search OR description LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

$totalSql = "SELECT COUNT(*) as total FROM projects $where";
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute($params);
$totalData = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalData / $itemsPerPage);

$dataSql = "SELECT * FROM projects $where ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$dataStmt = $pdo->prepare($dataSql);
foreach ($params as $key => $value) {
    $dataStmt->bindValue($key, $value, PDO::PARAM_STR);
}
$dataStmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
$dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$dataStmt->execute();
$projects = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Project Showcase - Main Kode</title>

    <link rel="icon" href="../assets/images/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-b from-[#0f0f0f] via-[#1a1a1a] to-[#0f0f0f] text-white min-h-screen mb-16">

    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>

    <div class="mt-20 flex flex-col items-center gap-4">
        <form method="GET" class="flex gap-2 w-full max-w-md">
            <input
                type="text"
                name="search"
                placeholder="Search projects..."
                value="<?= htmlspecialchars($search) ?>"
                class="px-5 py-2 rounded-l-lg bg-[#23272f] border-none focus:outline-none focus:ring-2 focus:ring-[#007acc] w-full text-white placeholder-gray-400 shadow-md transition-all duration-200">
            <button
                type="submit"
                class="px-5 py-2 rounded-r-lg bg-gradient-to-r from-[#007acc] to-[#005a99] hover:from-[#005a99] hover:to-[#007acc] text-white font-semibold shadow-md transition-all duration-200 flex items-center gap-2">
                <i class="bi bi-search text-lg"></i>
                <span class="hidden sm:inline">Search</span>
            </button>
        </form>
        <h1 class="text-2xl font-bold text-center bg-gradient-to-r from-[#007acc] to-[#005a99] bg-clip-text text-transparent drop-shadow-lg tracking-wide">
            Project Showcase
        </h1>
        <div class="h-1 w-24 bg-gradient-to-r from-[#007acc] to-[#005a99] rounded-full mt-1"></div>
    </div>

    <!-- Showcase Grid -->
    <div class="p-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php if (count($projects) > 0): ?>
            <?php foreach ($projects as $proj): ?>
                <div class="bg-[#1e1e1e] rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all">
                    <img src="../backend/uploads/projects/<?= htmlspecialchars($proj['image']) ?>" alt="Project Preview" class="w-full h-48 object-cover">
                    <div class="p-4 flex flex-col gap-2">
                        <h2 class="text-xl font-semibold"><?= htmlspecialchars($proj['title']) ?></h2>
                        <p class="text-sm text-gray-400"><?= strip_tags($proj['description'], '<p><br><strong><em><ul><ol><li>') ?></p>
                        <div class="flex gap-2 text-xs text-gray-300 flex-wrap">
                            <?php foreach (explode(',', $proj['tech_stack']) as $tech): ?>
                                <span class="bg-[#252526] px-2 py-1 rounded"><?= htmlspecialchars(trim($tech)) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= htmlspecialchars($proj['link']) ?>" target="_blank" class="mt-3 inline-block bg-[#007acc] hover:bg-[#005a99] px-4 py-2 rounded-lg text-sm text-white text-center">
                            View Project
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-400 col-span-full">No projects found</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="flex justify-center gap-2 pb-10">
            <?php if ($page > 1): ?>
                <a href="?search=<?= urlencode($search) ?>&page=<?= $page - 1 ?>" class="px-4 py-2 bg-[#007acc] hover:bg-[#005a99] rounded-lg">Prev</a>
            <?php endif; ?>

            <span class="px-4 py-2">Page <?= $page ?> of <?= $totalPages ?></span>

            <?php if ($page < $totalPages): ?>
                <a href="?search=<?= urlencode($search) ?>&page=<?= $page + 1 ?>" class="px-4 py-2 bg-[#007acc] hover:bg-[#005a99] rounded-lg">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</body>

</html>