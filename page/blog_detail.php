<?php
// Ambil koneksi database
include '../backend/connection/db.php';

// Ambil ID dari query string
$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID tidak ditemukan.');
}

// Ambil data blog berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM blog WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    die('Blog tidak ditemukan.');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($blog['judul']) ?></title>

    <!-- Icon -->
    <link rel="icon" href="../assets/images/logo.png" type="image/png" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS -->
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet" />

    <!-- Highlight.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-[#0f172a] text-white">

    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>

    <!-- Content -->
    <main class="max-w-4xl mx-auto py-16 px-6 md:px-0 text-white">

        <!-- Judul & Meta -->
        <article>
            <h1 class="text-4xl font-bold mb-4 leading-tight mt-5"><?= htmlspecialchars($blog['judul']) ?></h1>
            <div class="flex items-center text-sm text-gray-400 space-x-4 mb-8">
                <span><i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($blog['dibuat_pada'])) ?></span>
                <span><i class="bi bi-person-circle"></i> <?= htmlspecialchars($blog['nama'] ?? 'Admin') ?></span>
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
                <span><i class="bi bi-clock text-yellow-300"></i> <?= $estimasiBaca ?> Menit</span>
            </div>

            <!-- Gambar Header -->
            <?php if (!empty($blog['gambar'])): ?>
                <div class="rounded-xl overflow-hidden mb-10">
                    <img src="../backend/uploads/blog/<?= htmlspecialchars($blog['gambar']) ?>" alt="<?= htmlspecialchars($blog['judul']) ?>" class="w-full object-cover max-h-[400px]">
                </div>
            <?php endif; ?>

            <!-- Konten -->
            <article class="prose prose-invert max-w-none">
                <?= htmlspecialchars_decode($blog['isi']) ?>
            </article>


            <!-- Related Posts (dummy, bisa diganti logic berdasarkan tag nanti) -->
            <?php
            // Ambil semua tag ID yang terkait dengan blog saat ini
            $currentTagIds = [];
            $stmt = $pdo->prepare("SELECT tag_id FROM blog_tag WHERE blog_id = ?");
            $stmt->execute([$id]);
            $currentTagIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            $related = [];

            if (!empty($currentTagIds)) {
                // Query artikel lain yang memiliki tag yang sama (selain blog ini)
                $placeholders = implode(',', array_fill(0, count($currentTagIds), '?'));
                $params = [...$currentTagIds, $id];

                $sql = "
        SELECT b.*, GROUP_CONCAT(t.nama SEPARATOR ', ') AS tag_nama
        FROM blog b
        JOIN blog_tag bt ON b.id = bt.blog_id
        JOIN tag t ON t.id = bt.tag_id
        WHERE bt.tag_id IN ($placeholders) AND b.id != ?
        GROUP BY b.id
        ORDER BY b.dibuat_pada DESC
        LIMIT 3
    ";
                $stmtRelated = $pdo->prepare($sql);
                $stmtRelated->execute($params);
                $related = $stmtRelated->fetchAll(PDO::FETCH_ASSOC);
            }
            ?>

            <?php if (!empty($related)): ?>
                <section class="mt-20">
                    <h2 class="text-2xl font-semibold mb-6">Artikel Terkait</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($related as $item): ?>
                            <a href="blog_detail.php?id=<?= $item['id'] ?>" class="group bg-white/5 hover:bg-accent/10 border border-white/10 rounded-xl overflow-hidden transition backdrop-blur-sm">
                                <?php if (!empty($item['gambar'])): ?>
                                    <div class="h-40 bg-cover bg-center" style="background-image: url('../backend/uploads/<?= htmlspecialchars($item['gambar']) ?>');"></div>
                                <?php else: ?>
                                    <div class="h-40 bg-gray-700 flex items-center justify-center text-gray-400">Tidak ada gambar</div>
                                <?php endif; ?>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg group-hover:text-accent transition"><?= htmlspecialchars($item['judul']) ?></h3>
                                    <p class="text-sm text-gray-400 line-clamp-2"><?= mb_strimwidth(strip_tags($item['isi']), 0, 80, '...') ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>


    </main>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        AOS.init();
        hljs.highlightAll();
    </script>
    <script>
        tailwind.config = {
            theme: {
                extend: {},
            },
            plugins: [tailwindcssTypography],
        };
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
</body>

</html>