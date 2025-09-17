<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

if (!isset($_GET['id'])) die('ID tidak ditemukan');

$id = $_GET['id'];
$game = $pdo->query("SELECT * FROM games WHERE id = $id")->fetch();
if (!$game) die('Data game tidak ditemukan');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul         = $_POST['judul'];
    $file_size     = $_POST['file_size'];
    $rar_password  = $_POST['rar_password'];
    $download_link = $_POST['download_link'];
    $exclusive     = isset($_POST['exclusive']) ? 1 : 0;

    // Upload cover baru jika ada
    $cover = $game['cover_image'];
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

    // Update game
    $stmt = $pdo->prepare("UPDATE games 
                           SET title=?, cover_image=?, file_size=?, password_rar=?, download_link=?, is_exclusive=? 
                           WHERE id=?");
    $stmt->execute([$judul, $cover, $file_size, $rar_password, $download_link, $exclusive, $id]);

    header("Location: games_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
        }
    </style>
</head>

<body class="bg-gray-900 text-white min-h-screen p-6 flex">
    <!-- Sidebar -->
    <?php include '../components/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Game</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white/5 p-6 rounded-xl shadow-lg">
            <!-- Cover -->
            <div>
                <label class="block mb-2 font-semibold">Cover Game</label>
                <input type="file" name="cover" class="block w-full text-sm text-gray-300" />
                <?php if ($game['cover_image']): ?>
                    <img src="../../backend/uploads/games/<?= htmlspecialchars($game['cover_image']) ?>"
                        alt="Cover Game" class="mt-3 rounded-lg shadow-lg w-40">
                <?php endif; ?>
            </div>

            <!-- Judul -->
            <div>
                <label class="block mb-2 font-semibold">Judul Game</label>
                <input type="text" name="judul" value="<?= htmlspecialchars($game['title']) ?>" required
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- File Size -->
            <div>
                <label class="block mb-2 font-semibold">File Size</label>
                <input type="text" name="file_size" value="<?= htmlspecialchars($game['file_size']) ?>" required
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Password RAR -->
            <div>
                <label class="block mb-2 font-semibold">Password RAR</label>
                <input type="text" name="rar_password" value="<?= htmlspecialchars($game['password_rar']) ?>"
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Download Link -->
            <div>
                <label class="block mb-2 font-semibold">Link Download</label>
                <input type="url" name="download_link" value="<?= htmlspecialchars($game['download_link']) ?>" required
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Exclusive -->
            <div class="flex items-center">
                <input type="checkbox" name="exclusive" value="1" id="exclusive"
                    <?= $game['is_exclusive'] ? 'checked' : '' ?>
                    class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                <label for="exclusive" class="ml-2 text-sm font-semibold">Exclusive</label>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-6 py-2 rounded-lg">
                    Update Game
                </button>
            </div>
        </form>
    </div>
</body>

</html>