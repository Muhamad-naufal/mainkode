<section class="relative bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#334155] text-white py-20 px-4" id="project_showcase">
    <div class="max-w-6xl mx-auto">

        <!-- JUDUL -->
        <h2 class="text-4xl md:text-5xl font-extrabold text-center mb-16 after:block after:w-20 after:h-1 after:bg-accent after:mx-auto after:mt-4" data-aos="fade-down">
            Project Showcase
        </h2>

        <!-- GRID -->
        <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-10">
            <?php
            require_once 'backend/connection/db.php';
            $stmt = $pdo->prepare("SELECT * FROM projects ORDER BY created_at DESC LIMIT 3");
            $stmt->execute();
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($projects as $index => $proj):
            ?>
                <!-- KARTU PROJECT -->
                <div class="bg-white text-gray-800 rounded-3xl overflow-hidden shadow-xl group hover:shadow-2xl transition-all duration-500" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <img src="backend/uploads/projects/<?= htmlspecialchars($proj['image']) ?>" alt="Project Preview" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2 group-hover:text-accent transition-colors duration-300">
                            <?= htmlspecialchars($proj['title']) ?>
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            <?= htmlspecialchars(substr(strip_tags($proj['description']), 0, 80)) ?>...
                        </p>
                        <div class="flex gap-2 text-xs text-gray-500 flex-wrap mb-4">
                            <?php foreach (explode(',', $proj['tech_stack']) as $tech): ?>
                                <span class="bg-gray-200 px-2 py-1 rounded-full"><?= htmlspecialchars(trim($tech)) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= htmlspecialchars($proj['link']) ?>" target="_blank" class="inline-block bg-accent text-black px-4 py-2 rounded-full font-semibold hover:bg-accent-dark transition-colors duration-300">
                            Lihat Project
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- TOMBOL LEBIH BANYAK -->
        <div class="text-center mt-12">
            <a href="page/project.php" class="inline-block bg-accent text-white px-6 py-3 rounded-full font-semibold hover:bg-accent-dark transition-colors duration-300">
                Lihat Semua Project
            </a>
        </div>
    </div>
</section>