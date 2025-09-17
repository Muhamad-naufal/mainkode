<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']); // Misalnya: blog_index.php
?>

<aside id="sidebar" class="w-64 bg-white/5 backdrop-blur-md p-6 shadow-xl hidden md:block fixed md:relative z-20">
    <div class="flex items-center mb-10">
        <img src="../assets/images/logo.png" alt="Main Kode" class="w-10 h-10 mr-3 rounded-full border border-white/20">
        <h2 class="text-xl font-bold tracking-wide">Main Kode</h2>
    </div>

    <nav class="space-y-3">
        <a href="dashboard.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition sidebar-link <?= $currentPage === 'dashboard.php' ? 'active bg-white/10' : '' ?>">
            <i class="bi bi-house-door-fill text-lg"></i> Dashboard
        </a>

        <a href="../page/blog_index.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition sidebar-link <?= $currentPage === 'blog_index.php' ? 'active bg-white/10' : '' ?>">
            <i class="bi bi-journal-richtext text-lg"></i> Kelola Blog
        </a>
        <a href="../page/project_index.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition sidebar-link <?= $currentPage === 'project_index.php' ? 'active bg-white/10' : '' ?>">
            <i class="bi bi-briefcase-fill text-lg"></i> Kelola Proyek
        </a>
        <a href="../page/games_index.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition sidebar-link <?php echo $currentPage === 'games_index.php' ? 'active bg-white/10' : ''; ?>">
            <i class="bi bi-controller text-lg"></i> Kelola Game
        </a>

        <a href="../../backend/admin/logout.php"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition sidebar-link text-red-400 hover:text-red-500">
            <i class="bi bi-box-arrow-right text-lg"></i> Keluar
        </a>
    </nav>
</aside>