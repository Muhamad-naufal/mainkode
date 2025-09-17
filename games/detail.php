<?php
// detail.php

// Koneksi database
include '../backend/connection/db.php'; // sesuaikan path config DB kamu

// Ambil id dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Query database
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $game ? htmlspecialchars($game['title']) : 'Game Tidak Ditemukan' ?></title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />

    <style>
        .steam-dark {
            background: linear-gradient(180deg, #0b0f14 0%, #0a0d11 100%);
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .search-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #ddd;
        }
    </style>
</head>

<body class="steam-dark text-white min-h-screen">

    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="max-w-4xl mx-auto p-6">
        <div class="card rounded p-6">
            <?php if ($game): ?>
                <!-- Cover Image -->
                <img src="../backend/uploads/games/<?= htmlspecialchars($game['cover_image']) ?>"
                    alt="<?= htmlspecialchars($game['title']) ?>"
                    class="w-full rounded mb-6 h-64 object-cover">

                <!-- Game Info -->
                <h1 class="text-2xl font-bold mb-4"><?= htmlspecialchars($game['title']) ?></h1>

                <div class="space-y-2 mb-6">
                    <p><span class="font-semibold">File Size:</span> <?= htmlspecialchars($game['file_size']) ?> GB</p>
                    <p><span class="font-semibold">Password RAR:</span> <?= htmlspecialchars($game['password_rar']) ?></p>
                </div>

                <!-- Download Link -->
                <a href="<?= htmlspecialchars($game['download_link']) ?>"
                    class="inline-block px-6 py-3 rounded bg-blue-600 hover:bg-blue-700 font-semibold">
                    Download Game
                </a>
            <?php else: ?>
                <p class="text-center text-gray-400">Game tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>