<section class="relative bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#334155] text-white py-20 px-4" id="artikel">
    <div class="max-w-6xl mx-auto">

        <!-- JUDUL -->
        <h2 class="text-4xl md:text-5xl font-extrabold text-center mb-16 relative inline-block after:block after:w-20 after:h-1 after:bg-accent after:mx-auto after:mt-4" data-aos="fade-down">
            Artikel Terbaru
        </h2>

        <!-- GRID -->
        <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-10">
            <?php
            require_once 'backend/connection/db.php'; // sesuaikan path

            $stmt = $pdo->prepare("SELECT b.*, t.* FROM blog as b join blog_tag as bt on b.id = bt.blog_id join tag as t on bt.tag_id = t.id ORDER BY b.dibuat_pada DESC LIMIT 3");
            $stmt->execute();
            $artikel = $stmt->fetchAll();

            foreach ($artikel as $index => $a):
            ?>
                <!-- KARTU ARTIKEL -->
                <a href="page/blog_detail.php?id=<?= $a['id'] ?>" class="block">
                    <div class="bg-white text-gray-800 rounded-3xl overflow-hidden shadow-xl group hover:shadow-2xl transition-all duration-500" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <img src="backend/uploads/blog/<?= htmlspecialchars($a['gambar']) ?>" alt="cover" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2 group-hover:text-accent transition-colors duration-300">
                                <?= htmlspecialchars($a['judul']) ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars(substr(strip_tags($a['isi']), 0, 80)) ?>...</p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="bg-gray-200 px-2 py-1 rounded-full text-xs font-medium">#<?= htmlspecialchars($a['nama']) ?></span>
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