<?php
$posts = [
    [
        "username" => "Naufal",
        "avatar" => "https://i.pravatar.cc/100?img=1",
        "title" => "Welcome to Dark Forum",
        "content" => "Sekarang forum ini sudah full dark mode 🔥",
        "image" => "https://picsum.photos/600/400",
        "time" => "2 jam lalu"
    ],
    [
        "username" => "Aisyah",
        "avatar" => "https://i.pravatar.cc/100?img=2",
        "title" => "Diskusi Web Development",
        "content" => "Ada yang lagi belajar PHP dan Tailwind? Share tips dong!",
        "image" => null,
        "time" => "5 jam lalu"
    ]
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum DarkStyle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* agar hanya feed yang scroll */
        .feed-container {
            height: calc(100vh - 64px);
            /* dikurangi tinggi navbar */
            overflow-y: auto;
        }

        /* dropdown */
        .dropdown {
            display: none;
        }

        .dropdown.show {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-6 py-3 bg-gray-800 shadow sticky top-0 z-50">
        <div class="text-2xl font-bold text-indigo-400">ForumDark</div>
        <div class="flex items-center gap-4 relative">
            <button class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Post
            </button>
            <i class="bi bi-bell text-xl cursor-pointer"></i>

            <!-- Avatar + Dropdown -->
            <div class="relative">
                <img src="https://i.pravatar.cc/40" alt="profile" class="w-10 h-10 rounded-full cursor-pointer" id="avatarBtn">
                <div id="dropdownMenu" class="dropdown absolute right-0 mt-2 w-40 bg-gray-800 rounded-lg shadow-lg">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700">Profil</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Sidebar Kiri -->
        <aside class="hidden md:block md:col-span-1 bg-gray-800 p-4 rounded-xl shadow h-[calc(100vh-64px)] sticky top-[64px]">
            <div class="flex items-center gap-3 mb-6">
                <img src="https://i.pravatar.cc/60" class="w-14 h-14 rounded-full" alt="avatar">
                <div>
                    <h2 class="font-semibold">Naufal</h2>
                    <p class="text-sm text-gray-400">Web Enthusiast</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700">
                    <i class="bi bi-house-door"></i> <span>Beranda</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700">
                    <i class="bi bi-fire"></i> <span>Trending</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700">
                    <i class="bi bi-chat"></i> <span>Diskusi</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700">
                    <i class="bi bi-gear"></i> <span>Pengaturan</span>
                </a>
            </div>
        </aside>

        <!-- Feed (scroll only middle) -->
        <main class="md:col-span-2 feed-container space-y-6 p-2">
            <?php foreach ($posts as $post): ?>
                <div class="bg-gray-800 rounded-xl shadow p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="<?= $post['avatar'] ?>" class="w-12 h-12 rounded-full" alt="avatar">
                        <div>
                            <h3 class="font-semibold"><?= $post['username'] ?></h3>
                            <p class="text-xs text-gray-400"><?= $post['time'] ?></p>
                        </div>
                    </div>
                    <h2 class="text-lg font-bold mb-2"><?= $post['title'] ?></h2>
                    <p class="text-gray-300 mb-3"><?= $post['content'] ?></p>
                    <?php if ($post['image']): ?>
                        <img src="<?= $post['image'] ?>" class="w-full rounded-lg mb-3">
                    <?php endif; ?>
                    <div class="flex justify-between text-gray-400 text-sm">
                        <span class="cursor-pointer hover:text-red-400"><i class="bi bi-heart"></i> Suka</span>
                        <span class="cursor-pointer hover:text-indigo-400"><i class="bi bi-chat"></i> Komentar</span>
                        <span class="cursor-pointer hover:text-green-400"><i class="bi bi-share"></i> Bagikan</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </main>

        <!-- Sidebar Kanan -->
        <aside class="hidden md:block md:col-span-1 bg-gray-800 p-4 rounded-xl shadow h-[calc(100vh-64px)] sticky top-[64px]">
            <h2 class="font-bold mb-4 text-indigo-400">🔥 Trending Topics</h2>
            <ul class="space-y-2">
                <li class="hover:text-indigo-400 cursor-pointer">#PHP</li>
                <li class="hover:text-indigo-400 cursor-pointer">#TailwindCSS</li>
                <li class="hover:text-indigo-400 cursor-pointer">#Bootstrap</li>
                <li class="hover:text-indigo-400 cursor-pointer">#ForumDev</li>
            </ul>
        </aside>

    </div>

    <script>
        // dropdown toggle
        const avatarBtn = document.getElementById("avatarBtn");
        const dropdownMenu = document.getElementById("dropdownMenu");
        avatarBtn.addEventListener("mouseenter", () => dropdownMenu.classList.add("show"));
        avatarBtn.addEventListener("mouseleave", () => {
            setTimeout(() => dropdownMenu.classList.remove("show"), 500);
        });
        dropdownMenu.addEventListener("mouseenter", () => dropdownMenu.classList.add("show"));
        dropdownMenu.addEventListener("mouseleave", () => dropdownMenu.classList.remove("show"));
    </script>

</body>

</html>