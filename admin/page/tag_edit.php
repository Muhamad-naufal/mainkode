<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tag WHERE id = ?");
$stmt->execute([$id]);
$tag = $stmt->fetch();

if (!$tag) {
    die("Tag tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];

    $stmt = $pdo->prepare("UPDATE tag SET nama = ? WHERE id = ?");
    $stmt->execute([$nama, $id]);

    header("Location: tag_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Tag</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white p-6">
    <div class="max-w-xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold">Edit Tag</h1>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block font-semibold mb-1">Nama Tag</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($tag['nama']) ?>" required class="w-full px-4 py-2 rounded bg-white/10">
            </div>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 px-6 py-2 rounded text-white font-semibold">
                Update
            </button>
        </form>
        <a href="tag_index.php" class="text-sm text-blue-400 hover:underline">&larr; Kembali ke Daftar Tag</a>
    </div>
</body>

</html>