<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul         = $_POST['judul'];
    $file_size     = $_POST['file_size'];
    $rar_password  = $_POST['rar_password'];
    $download_link = $_POST['download_link'];
    $exclusive     = isset($_POST['exclusive']) ? 1 : 0; // checkbox

    // Upload cover game
    $cover = '';
    if (!empty($_FILES['cover']['name'])) {
        $imageName = time() . '_' . basename($_FILES['cover']['name']);
        $target    = '../../backend/uploads/games/' . $imageName;
        if (!is_dir('../../backend/uploads/games/')) {
            mkdir('../../backend/uploads/games/', 0777, true);
        }
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            $cover = $imageName;
        }
    }

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO games (title, cover_image, file_size, password_rar, download_link, is_exclusive) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$judul, $cover, $file_size, $rar_password, $download_link, $exclusive]);

    header("Location: games_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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

<body class="bg-gray-950 text-white flex">
    <?php include '../components/sidebar.php'; ?>

    <main class="flex-1 p-8 md:ml-64">
        <div class="max-w-3xl">
            <h1 class="text-2xl font-bold mb-6">Tambah Game Baru</h1>
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white/5 p-6 rounded-xl shadow-lg">

                <!-- Cover -->
                <div>
                    <label class="block mb-2 font-semibold">Cover Game</label>
                    <input type="file" name="cover" accept="image/*" class="text-sm text-gray-300" />
                </div>

                <!-- Judul -->
                <div>
                    <label class="block mb-2 font-semibold">Judul Game</label>
                    <input type="text" name="judul" required
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- File Size -->
                <div>
                    <label class="block mb-2 font-semibold">File Size</label>
                    <input type="text" name="file_size" placeholder="Contoh: 5 GB" required
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Password RAR -->
                <div>
                    <label class="block mb-2 font-semibold">Password RAR</label>
                    <input type="text" name="rar_password" placeholder="Kosongkan jika tidak ada"
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Download Link -->
                <div>
                    <label class="block mb-2 font-semibold">Link Download</label>
                    <input type="url" name="download_link" required
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Exclusive -->
                <div class="flex items-center">
                    <input type="checkbox" name="exclusive" value="1" id="exclusive"
                        class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                    <label for="exclusive" class="ml-2 text-sm font-semibold">Exclusive</label>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded shadow font-semibold">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>