<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];

    $stmt = $pdo->prepare("INSERT INTO tag (nama) VALUES (?)");
    $stmt->execute([$nama]);

    header("Location: tag_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Tag</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white p-6">
    <div class="max-w-xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold">Tambah Tag</h1>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block font-semibold mb-1">Nama Tag</label>
                <input type="text" name="nama" required class="w-full px-4 py-2 rounded bg-white/10">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded text-white font-semibold">
                Simpan
            </button>
        </form>
        <a href="tag_index.php" class="text-sm text-blue-400 hover:underline">&larr; Kembali ke Daftar Tag</a>
    </div>
</body>

</html>