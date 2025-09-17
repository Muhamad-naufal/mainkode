<!-- GAME LIST -->
<section class="max-w-7xl mx-auto mt-6 grid grid-cols-1 lg:grid-cols-4 gap-8 px-4">

    <!-- LEFT: Exclusive -->
    <aside class="lg:col-span-1 space-y-4 lg:sticky lg:top-20 self-start">
        <h2 class="text-xl font-bold mb-3 border-b border-gray-700 pb-2">🔥 Exclusive Games</h2>
        <div class="grid gap-5">
            <?php if (!empty($exclusive)): ?>
                <?php foreach ($exclusive as $ex): ?>
                    <a href="detail.php?id=<?= $ex['id'] ?>" class="block">
                        <div class="card p-3 rounded bg-gray-900 transition transform hover:scale-[1.02] hover:shadow-lg hover:shadow-blue-600/20">
                            <img src="../backend/uploads/games/<?= htmlspecialchars($ex['cover_image']) ?>"
                                alt="<?= htmlspecialchars($ex['title']) ?>"
                                class="w-full h-40 object-cover rounded">
                            <h3 class="font-semibold text-white text-sm mt-3"><?= htmlspecialchars($ex['title']) ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-400">Belum ada game exclusive.</p>
            <?php endif; ?>
        </div>
    </aside>



    <!-- RIGHT: All Games -->
    <div class="lg:col-span-3 space-y-6">
        <h2 class="text-xl font-bold border-b border-gray-700 pb-2">🎮 Semua Game</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php if ($games): ?>
                <?php foreach ($games as $g): ?>
                    <a href="detail.php?id=<?= $g['id'] ?>" class="block">
                        <div class="card p-3 rounded bg-gray-900 transition transform hover:scale-[1.02] hover:shadow-lg hover:shadow-blue-600/20">
                            <img src="../backend/uploads/games/<?= htmlspecialchars($g['cover_image']) ?>"
                                alt="<?= htmlspecialchars($g['title']) ?>"
                                class="w-full h-40 object-cover rounded" />
                            <h3 class="font-semibold text-white text-sm mt-3"><?= htmlspecialchars($g['title']) ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-400">Tidak ada game ditemukan.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            <nav class="inline-flex space-x-1 text-sm font-medium">
                <?php if ($page > 1): ?>
                    <a href="?q=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>" class="px-3 py-1 rounded bg-gray-800 hover:bg-blue-600">&laquo;</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?q=<?= urlencode($keyword) ?>&page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-gray-800 hover:bg-blue-600' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <a href="?q=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>" class="px-3 py-1 rounded bg-gray-800 hover:bg-blue-600">&raquo;</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</section>