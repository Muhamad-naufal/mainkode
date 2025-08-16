<div class="row g-4">
    <?php for ($i = 1; $i <= 6; $i++): ?>
        <div class="col-md-4">
            <a href="thread.php?id=<?= $i ?>" class="text-decoration-none text-white">
                <div class="thread-card rounded-lg p-3 h-100">
                    <!-- Header -->
                    <div class="d-flex align-items-center mb-2 gap-2">
                        <img src="https://i.pravatar.cc/40?img=<?= $i ?>" class="rounded-circle" alt="avatar">
                        <div>
                            <h5 class="mb-0 font-semibold">Thread Title <?= $i ?></h5>
                            <small class="text-gray-400">by User<?= $i ?> · <?= rand(1, 10) ?> days ago</small>
                        </div>
                    </div>
                    <!-- Content preview -->
                    <p class="text-gray-300 text-sm mb-3">
                        This is a short preview of thread <?= $i ?> content. Click to see more details inside...
                    </p>
                    <!-- Footer -->
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-success">Open</span>
                        <span class="badge bg-secondary"><?= rand(0, 20) ?> comments</span>
                    </div>
                </div>
            </a>
        </div>
    <?php endfor; ?>
</div>