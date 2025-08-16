<?php
$activePage = "beranda"; // ganti sesuai halaman: "beranda", "trending", "diskusi", "pengaturan"

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
        "username" => "Eka Wulandari",
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
    <link rel="icon" type="image/x-icon" href="../assets/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .feed-container {
            height: calc(100vh - 64px - 56px);
            overflow-y: auto;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .feed-container::-webkit-scrollbar {
            display: none;
        }

        .feed-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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
        <div class="text-2xl font-bold text-indigo-400">Mainkode Forum</div>
        <div class="flex items-center gap-4 relative">
            <button class="hidden md:flex bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg items-center gap-2">
                <i class="bi bi-plus-lg"></i> Postingan
            </button>
            <div class="relative">
                <i id="notifBtn" class="bi bi-bell text-2xl cursor-pointer hover:text-red-500"></i>
                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-1">3</span>
                <div id="notifDropdown" class="dropdown absolute right-0 mt-2 w-72 bg-gray-800 rounded-lg shadow-lg z-50">
                    <div class="p-4 border-b border-gray-700 font-semibold text-indigo-400">Notifikasi</div>
                    <ul class="max-h-60 overflow-y-auto">
                        <li class="px-4 py-3 hover:bg-gray-700 flex items-start gap-2">
                            <i class="bi bi-chat-left-dots text-indigo-400 mt-1"></i>
                            <div>
                                <span class="font-medium">Eka Wulandari</span> mengomentari postinganmu.
                                <div class="text-xs text-gray-400">2 menit lalu</div>
                            </div>
                        </li>
                        <li class="px-4 py-3 hover:bg-gray-700 flex items-start gap-2">
                            <i class="bi bi-heart text-red-400 mt-1"></i>
                            <div>
                                <span class="font-medium">Naufal</span> menyukai postinganmu.
                                <div class="text-xs text-gray-400">10 menit lalu</div>
                            </div>
                        </li>
                        <li class="px-4 py-3 hover:bg-gray-700 flex items-start gap-2">
                            <i class="bi bi-person-plus text-green-400 mt-1"></i>
                            <div>
                                <span class="font-medium">Sarah K</span> mulai mengikuti kamu.
                                <div class="text-xs text-gray-400">1 jam lalu</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <script>
                // Notification dropdown toggle
                const notifBtn = document.getElementById("notifBtn");
                const notifDropdown = document.getElementById("notifDropdown");
                document.addEventListener("click", function(e) {
                    if (notifBtn.contains(e.target)) {
                        notifDropdown.classList.toggle("show");
                    } else if (!notifDropdown.contains(e.target)) {
                        notifDropdown.classList.remove("show");
                    }
                });
            </script>
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
        <aside class="hidden mt-5 mb-5 md:block md:col-span-1 bg-gray-800 p-4 rounded-xl shadow h-[calc(100vh-64px)] sticky top-[64px]">
            <div class="flex items-center gap-3 mb-6">
                <img src="https://i.pravatar.cc/60" class="w-14 h-14 rounded-full" alt="avatar">
                <div>
                    <h2 class="font-semibold">Naufal</h2>
                    <p class="text-sm text-gray-400">Web Enthusiast</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg <?= $activePage == 'beranda' ? 'bg-indigo-600 text-white' : 'hover:bg-gray-700' ?>">
                    <i class="bi bi-house-door"></i> <span>Beranda</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg <?= $activePage == 'trending' ? 'bg-indigo-600 text-white' : 'hover:bg-gray-700' ?>">
                    <i class="bi bi-fire"></i> <span>Trending</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg <?= $activePage == 'diskusi' ? 'bg-indigo-600 text-white' : 'hover:bg-gray-700' ?>">
                    <i class="bi bi-chat"></i> <span>Diskusi</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg <?= $activePage == 'pengaturan' ? 'bg-indigo-600 text-white' : 'hover:bg-gray-700' ?>">
                    <i class="bi bi-gear"></i> <span>Pengaturan</span>
                </a>
            </div>
        </aside>

        <!-- Feed -->
        <main class="md:col-span-2 feed-container space-y-6 px-2">
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
                    <div class="flex justify-between text-gray-400 text-sm mt-2">
                        <span class="cursor-pointer hover:text-red-400 flex items-center space-x-1" onclick="toggleLike(this)">
                            <i class="bi bi-heart"></i>
                            <span class="ml-1 like-count">0</span>
                        </span>

                        <span class="cursor-pointer hover:text-indigo-400" onclick="openComments()"><i class="bi bi-chat"></i> (3)</span>

                        <span class="cursor-pointer hover:text-green-400 flex items-center space-x-1" onclick="sharePost()">
                            <i class="bi bi-share"></i>
                        </span>
                    </div>

                    <!-- Modal Komentar -->
                    <div id="commentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white rounded-lg shadow-lg w-96 max-h-[80vh] overflow-y-auto relative">

                            <!-- Header -->
                            <div class="flex justify-between items-center p-4 border-b">
                                <h2 class="font-semibold text-gray-700">💬 Komentar (3)</h2>
                                <button onclick="closeComments()" class="text-gray-500 hover:text-gray-700">&times;</button>
                            </div>

                            <!-- Daftar Komentar -->
                            <div class="p-4 space-y-3 text-black">
                                <div class="flex space-x-2">
                                    <img src="https://i.pravatar.cc/35?img=1" class="w-8 h-8 rounded-full" alt="user1">
                                    <div>
                                        <p class="text-sm font-semibold">John Doe</p>
                                        <p class="text-xs text-gray-600">Keren banget postingannya 🔥</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <img src="https://i.pravatar.cc/35?img=2" class="w-8 h-8 rounded-full" alt="user2">
                                    <div>
                                        <p class="text-sm font-semibold">Sarah K</p>
                                        <p class="text-xs text-gray-600">Setuju banget, inspiratif 👍</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <img src="https://i.pravatar.cc/35?img=3" class="w-8 h-8 rounded-full" alt="user3">
                                    <div>
                                        <p class="text-sm font-semibold">Alex P</p>
                                        <p class="text-xs text-gray-600">Mantap bro, lanjutkan!</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Komentar -->
                            <div class="p-3 border-t flex items-center space-x-2">
                                <input type="text" placeholder="Tulis komentar..." class="flex-1 border text-black rounded px-3 py-1 text-sm focus:outline-none focus:ring focus:ring-indigo-300">
                                <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-sm">Kirim</button>
                            </div>
                        </div>
                    </div>

                    <!-- Script Modal -->
                    <script>
                        function openComments() {
                            document.getElementById("commentModal").classList.remove("hidden");
                        }

                        function closeComments() {
                            document.getElementById("commentModal").classList.add("hidden");
                        }
                    </script>

                    <!-- Kolom komentar yang disembunyikan dulu -->
                    <div class="hidden mt-2 comment-box">
                        <input type="text" placeholder="Tulis komentar..." class="w-full border rounded p-2 text-sm" />
                    </div>
                    <script>
                        function toggleLike(el) {
                            const icon = el.querySelector("i");
                            const count = el.querySelector(".like-count");
                            let current = parseInt(count.textContent);

                            if (icon.classList.contains("text-red-500")) {
                                icon.classList.remove("text-red-500");
                                count.textContent = current - 1;
                            } else {
                                icon.classList.add("text-red-500");
                                count.textContent = current + 1;
                            }
                        }

                        function sharePost() {
                            navigator.clipboard.writeText(window.location.href).then(() => {
                                alert("Link berhasil disalin!");
                            });
                        }
                    </script>

                </div>
            <?php endforeach; ?>
        </main>

        <!-- Sidebar Kanan -->
        <aside class="hidden md:block mt-5 mb-5 md:col-span-1 bg-gray-800 p-4 rounded-xl shadow h-[calc(100vh-64px)] sticky top-[64px] flex flex-col justify-between">
            <!-- Trending Topics -->
            <div>
                <h2 class="font-bold mb-4 text-indigo-400">🔥 Trending Topics</h2>
                <ul class="space-y-2">
                    <li class="hover:text-indigo-400 cursor-pointer">#PHP</li>
                    <li class="hover:text-indigo-400 cursor-pointer">#TailwindCSS</li>
                    <li class="hover:text-indigo-400 cursor-pointer">#Bootstrap</li>
                    <li class="hover:text-indigo-400 cursor-pointer">#ForumDev</li>
                </ul>
            </div>

            <!-- Recommended Friends -->
            <div class="mt-6">
                <h2 class="font-bold mb-4 text-green-400">👥 Recommended Friends</h2>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="https://i.pravatar.cc/40?img=1" class="w-8 h-8 rounded-full" alt="user1">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium">John Doe</span>
                                <span class="text-xs text-gray-400">Web Enthusiast • 1.2k followers</span>
                            </div>
                        </div>
                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-2 py-1 rounded">Follow</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="https://i.pravatar.cc/40?img=2" class="w-8 h-8 rounded-full" alt="user2">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium">Sarah K</span>
                                <span class="text-xs text-gray-400">UI/UX Designer • 980 followers</span>
                            </div>
                        </div>
                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-2 py-1 rounded">Follow</button>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="https://i.pravatar.cc/40?img=3" class="w-8 h-8 rounded-full" alt="user3">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium">Alex P</span>
                                <span class="text-xs text-gray-400">Backend Dev • 2.3k followers</span>
                            </div>
                        </div>
                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-2 py-1 rounded">Follow</button>
                    </li>
                </ul>
            </div>

        </aside>

    </div>

    <!-- Bottom Nav (mobile only) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-gray-800 border-t border-gray-700 shadow-lg z-50">
        <div class="flex justify-around items-center py-2 text-gray-400">
            <a href="#" class="flex flex-col items-center <?= $activePage == 'beranda' ? 'text-indigo-400' : 'hover:text-indigo-400' ?>">
                <i class="bi bi-house-door text-xl"></i>
                <span class="text-xs">Beranda</span>
            </a>
            <a href="#" class="flex flex-col items-center <?= $activePage == 'trending' ? 'text-indigo-400' : 'hover:text-indigo-400' ?>">
                <i class="bi bi-fire text-xl"></i>
                <span class="text-xs">Trending</span>
            </a>
            <a href="#" class="flex flex-col items-center hover:text-indigo-400">
                <i class="bi bi-plus-circle text-2xl text-indigo-500"></i>
            </a>
            <a href="#" class="flex flex-col items-center <?= $activePage == 'diskusi' ? 'text-indigo-400' : 'hover:text-indigo-400' ?>">
                <i class="bi bi-chat text-xl"></i>
                <span class="text-xs">Diskusi</span>
            </a>
            <a href="#" class="flex flex-col items-center <?= $activePage == 'pengaturan' ? 'text-indigo-400' : 'hover:text-indigo-400' ?>">
                <i class="bi bi-gear text-xl"></i>
                <span class="text-xs">Pengaturan</span>
            </a>
        </div>
    </nav>

    <script>
        const avatarBtn = document.getElementById("avatarBtn");
        const dropdownMenu = document.getElementById("dropdownMenu");
        avatarBtn.addEventListener("mouseenter", () => dropdownMenu.classList.add("show"));
        avatarBtn.addEventListener("mouseleave", () => {
            setTimeout(() => dropdownMenu.classList.remove("show"), 400);
        });
        dropdownMenu.addEventListener("mouseenter", () => dropdownMenu.classList.add("show"));
        dropdownMenu.addEventListener("mouseleave", () => dropdownMenu.classList.remove("show"));
    </script>

</body>

</html>