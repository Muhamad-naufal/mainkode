<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';
// Dummy data statistik (nanti bisa diambil dari database)
$total_blog = $pdo->query("SELECT COUNT(*) FROM blog")->fetchColumn();
$total_projects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Main Kode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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

<body class="text-white font-sans">

    <!-- Sidebar mobile toggle -->
    <div class="md:hidden p-4 flex justify-between items-center bg-white/5 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <img src="../assets/images/logo.png" alt="Main Kode" class="w-8 h-8 rounded-full border border-white/10">
            <span class="font-bold text-lg">Main Kode Admin</span>
        </div>
        <button id="toggleSidebar" class="text-white text-xl">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <!-- Sidebar + Content wrapper -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; ?>

        <!-- Main content -->
        <main class="flex-1 md:ml-64 p-6 transition-all">
            <h1 class="text-3xl font-bold mb-4" data-aos="fade-down">Selamat datang, Admin 👋</h1>
            <p class="text-gray-300 mb-6">Kelola konten <strong>Blog</strong> kamu di sini.</p>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" data-aos="fade-up">
                <div class="bg-gradient-to-tr from-fuchsia-600 to-pink-500 p-5 rounded-xl shadow-lg">
                    <h2 class="text-xl font-semibold"><i class="bi bi-journal-text mr-2"></i> Total Blog</h2>
                    <p class="text-4xl font-bold mt-2"><?= $total_blog ?></p>
                </div>
                <div class="bg-gradient-to-tr from-blue-600 to-cyan-500 p-5 rounded-xl shadow-lg">
                    <h2 class="text-xl font-semibold"><i class="bi bi-briefcase mr-2"></i> Total Projects</h2>
                    <p class="text-4xl font-bold mt-2"><?= $total_projects ?></p>
                </div>
            </div>

            <!-- Konten lanjutan -->
            <div data-aos="fade-up" class="bg-white/5 rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-2">Panduan Cepat 🚀</h3>
                <ul class="list-disc list-inside text-gray-300 space-y-1 text-sm">
                    <li>Gunakan menu sidebar untuk navigasi.</li>
                    <li>Blog untuk artikel dan update.</li>
                    <li>Projects untuk showcase karya.</li>
                    <li>Logout saat selesai agar tetap aman.</li>
                </ul>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script>
        // Toggle sidebar mobile
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>

</html>