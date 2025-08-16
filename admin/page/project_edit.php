<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

if (!isset($_GET['id'])) die('ID tidak ditemukan');

$id = $_GET['id'];
$project = $pdo->query("SELECT * FROM projects WHERE id = $id")->fetch();
if (!$project) die('Data tidak ditemukan');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $tech_stack = $_POST['tech_stack']; // disimpan dalam format: TailwindCSS, Alpine.js
    $image = $_FILES['image']['name'] ?: $project['image'];

    if ($_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../../backend/uploads/' . $image);
    }

    // Update project
    $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, link=?, tech_stack=?, image=? WHERE id=?");
    $stmt->execute([$title, $description, $link, $tech_stack, $image, $id]);

    header("Location: project_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Project Showcase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tiny.cloud/1/l17bkui8wk8wg0e7jxwczbqlu26kl09t28ayh11jg5usgeo8/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'link lists media image table code',
            toolbar: 'undo redo | styles | bold italic underline | link image | bullist numlist | code',
            height: 250
        });
    </script>
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
        <h1 class="text-2xl font-bold mb-6">Edit Project Showcase</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-2xl mx-auto text-white">
            <!-- Gambar -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Gambar (opsional)</label>
                <input type="file" name="image" class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700" />
                <?php if ($project['image']): ?>
                    <img src="../../backend/uploads/projects/<?= $project['image'] ?>" alt="Gambar Project" class="mt-3 rounded-lg shadow-lg w-52">
                <?php endif; ?>
            </div>

            <!-- Judul -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Judul Project</label>
                <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>

            <!-- Link -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Link Project</label>
                <input type="url" name="link" value="<?= htmlspecialchars($project['link']) ?>" placeholder="https://..."
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>

            <!-- Tech Stack -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Tech Stack</label>
                <input type="text" name="tech_stack" value="<?= htmlspecialchars($project['tech_stack']) ?>" placeholder="Contoh: TailwindCSS, Alpine.js, PHP"
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" />
                <small class="text-sm text-gray-400">Pisahkan dengan koma (,) jika lebih dari satu.</small>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Deskripsi Project</label>
                <textarea name="description" id="description" class="w-full h-64 bg-white/10 rounded-lg"><?= htmlspecialchars($project['description']) ?></textarea>
            </div>

            <!-- Tombol Submit -->
            <div>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 transition-all duration-200 text-white font-medium px-6 py-2 rounded-lg">
                    Update Project
                </button>
            </div>
        </form>
    </div>
</body>

</html>