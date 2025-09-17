<?php
require_once '../backend/connection/db.php';

$search = $_GET['search'] ?? '';
$tagId = $_GET['tag'] ?? '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$where = '1';
$params = [];

if (!empty($search)) {
    $where .= " AND b.judul LIKE :search";
    $params['search'] = "%$search%";
}

if (!empty($tagId)) {
    $where .= " AND EXISTS (
        SELECT 1 FROM blog_tag bt WHERE bt.blog_id = b.id AND bt.tag_id = :tagId
    )";
    $params['tagId'] = $tagId;
}

$sql = "SELECT b.*, GROUP_CONCAT(t.nama SEPARATOR ', ') as tag_names
        FROM blog b
        LEFT JOIN blog_tag bt ON b.id = bt.blog_id
        LEFT JOIN tag t ON t.id = bt.tag_id
        WHERE $where
        GROUP BY b.id
        ORDER BY b.dibuat_pada DESC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$blogs = $stmt->fetchAll();

$totalSql = "SELECT COUNT(DISTINCT b.id) FROM blog b
             LEFT JOIN blog_tag bt ON b.id = bt.blog_id
             WHERE $where";
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute($params);
$totalBlogs = $totalStmt->fetchColumn();
$totalPages = ceil($totalBlogs / $limit);

$allTags = $pdo->query("SELECT * FROM tag ORDER BY nama")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog - Main Kode</title>

    <link rel="icon" href="../assets/images/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="../assets/css/custom.css" />
</head>

<body class="bg-main text-white">

    <?php include 'components/navbar.php'; ?>
    <?php include 'components/hero.php'; ?>

    <main class="max-w-7xl mx-auto py-16 px-6 md:px-12 text-white bg-gradient-to-b mt-16 mb-16 from-[#0f0f0f] via-[#1a1a1a] to-[#0f0f0f] rounded-3xl shadow-xl">
        <h1 class="text-3xl md:text-4xl font-bold mb-8 text-center">Blog Terbaru</h1>

        <!-- Search & Filter -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari blog..." class="px-4 py-2 rounded bg-white/10" />
            <select name="tag" class="px-4 py-2 rounded bg-white/10 text-black">
                <option value="">-- Semua Tag --</option>
                <?php foreach ($allTags as $tag): ?>
                    <option value="<?= $tag['id'] ?>" <?= $tagId == $tag['id'] ? 'selected' : '' ?>><?= htmlspecialchars($tag['nama']) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Filter</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($blogs as $blog): ?>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 shadow-xl hover:shadow-yellow-500/30 transition-all duration-300 group overflow-hidden flex flex-col">
                    <?php if (!empty($blog['gambar'])): ?>
                        <img src="../backend/uploads/blog/<?= htmlspecialchars($blog['gambar']) ?>"
                            alt="<?= htmlspecialchars($blog['judul']) ?>"
                            class="object-cover w-full h-48 group-hover:scale-105 transition-transform duration-300">
                    <?php else: ?>
                        <div class="bg-gray-900 flex items-center justify-center h-48">
                            <i class="bi bi-image text-5xl text-gray-600"></i>
                        </div>
                    <?php endif; ?>

                    <div class="p-4 flex flex-col justify-between flex-1">
                        <div>
                            <h2 class="text-lg font-bold mb-2 text-yellow-300 hover:text-yellow-400 transition-colors line-clamp-2">
                                <a href="blog_detail.php?id=<?= $blog['id'] ?>">
                                    <?= htmlspecialchars($blog['judul']) ?>
                                </a>
                            </h2>

                            <div class="flex flex-wrap gap-1 mb-3">
                                <?php if (!empty($blog['tag_names'])): ?>
                                    <?php foreach (explode(',', $blog['tag_names']) as $tagName): ?>
                                        <span class="bg-yellow-400/10 text-yellow-300 px-2 py-0.5 rounded-full text-[10px] font-medium shadow-inner">
                                            #<?= htmlspecialchars(trim($tagName)) ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <p class="text-sm text-gray-300 mb-4 leading-relaxed line-clamp-2">
                                <?= htmlspecialchars(strip_tags($blog['isi'])) ?>
                            </p>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-clock text-yellow-300"></i>
                                <?php
                                // Hitung estimasi baca: 200 kata/menit, fallback ke 3 menit jika kosong
                                $isi = strip_tags($blog['isi']);
                                $wordCount = str_word_count($isi);
                                $charCount = mb_strlen($isi);
                                $wordsPerMinute = 200;
                                $charsPerMinute = 1000;
                                $estimasiBaca = max(
                                    ceil($wordCount / $wordsPerMinute),
                                    ceil($charCount / $charsPerMinute),
                                    1
                                );
                                ?>
                                <span><?= $estimasiBaca ?> Menit</span>
                                <span class="mx-1">•</span>
                                <span><?= date('d M Y', strtotime($blog['dibuat_pada'])) ?></span>
                            </div>
                            <a href="blog_detail.php?id=<?= $blog['id'] ?>"
                                class="inline-flex items-center gap-1 text-yellow-300 hover:text-yellow-400 font-semibold transition-colors">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($blogs)): ?>
                <div class="col-span-full text-center text-gray-500 py-12 text-lg">Tidak ada blog ditemukan.</div>
            <?php endif; ?>
        </div>



        <!-- Pagination -->
        <div class="mt-8 flex justify-center gap-2">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?= urlencode($search) ?>&tag=<?= $tagId ?>&page=<?= $i ?>"
                    class="px-4 py-2 rounded <?= $i == $page ? 'bg-yellow-500 text-white' : 'bg-white/10 hover:bg-white/20' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>