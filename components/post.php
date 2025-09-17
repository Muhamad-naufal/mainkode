<section class="relative bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#334155] text-white py-20 px-4" id="artikel">
    <div class="max-w-6xl mx-auto">

        <!-- JUDUL -->
        <h2 class="text-4xl md:text-5xl font-extrabold text-center mb-16 relative inline-block after:block after:w-20 after:h-1 after:bg-accent after:mx-auto after:mt-4" data-aos="fade-down">
            Artikel Terbaru
        </h2>

        <!-- GRID -->
        <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-10">
            <?php
            require_once 'backend/connection/db.php';

            $stmt = $pdo->prepare("
        SELECT 
            b.id as blog_id, 
            b.judul, 
            b.isi, 
            b.gambar, 
            b.dibuat_pada, 
            GROUP_CONCAT(t.nama SEPARATOR ',') as tags
        FROM blog as b 
        JOIN blog_tag as bt ON b.id = bt.blog_id 
        JOIN tag as t ON bt.tag_id = t.id 
        GROUP BY b.id
        ORDER BY b.dibuat_pada DESC 
        LIMIT 3
    ");
            $stmt->execute();
            $artikel = $stmt->fetchAll();

            foreach ($artikel as $index => $a):
                $tagList = explode(',', $a['tags']); // ubah string jadi array
            ?>
                <!-- KARTU ARTIKEL -->
                <a href="page/blog_detail.php?id=<?= $a['blog_id'] ?>" class="block">
                    <div class="bg-white text-gray-800 rounded-3xl overflow-hidden shadow-xl group hover:shadow-2xl transition-all duration-500" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <img src="backend/uploads/blog/<?= htmlspecialchars($a['gambar']) ?>" alt="cover" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2 group-hover:text-accent transition-colors duration-300">
                                <?= htmlspecialchars($a['judul']) ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                <?= htmlspecialchars(substr(strip_tags($a['isi']), 0, 80)) ?>...
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex gap-2 flex-wrap">
                                    <?php foreach ($tagList as $tag): ?>
                                        <span class="bg-gray-200 px-2 py-1 rounded-full text-xs font-medium">
                                            #<?= htmlspecialchars(trim($tag)) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                                <span><?= date('d M Y', strtotime($a['dibuat_pada'])) ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>


        <!-- TOMBOL LEBIH BANYAK -->
        <div class="text-center mt-12">
            <a href="page/blog.php" class="inline-block bg-accent text-white px-6 py-3 rounded-full font-semibold hover:bg-accent-dark transition-colors duration-300">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>