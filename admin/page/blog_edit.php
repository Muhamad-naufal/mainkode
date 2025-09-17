<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

if (!isset($_GET['id'])) die('ID tidak ditemukan');

$id = $_GET['id'];
$blog = $pdo->query("SELECT * FROM blog WHERE id = $id")->fetch();
if (!$blog) die('Data tidak ditemukan');

// Ambil semua tag untuk select option
$allTags = $pdo->query("SELECT * FROM tag ORDER BY nama")->fetchAll();

// Ambil tag yang sudah dipilih blog ini
$selectedTags = $pdo->query("SELECT tag_id FROM blog_tag WHERE blog_id = $id")->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
    $isi = $_POST['isi'];
    $tags = $_POST['tags'] ?? [];
    $gambar = $_FILES['gambar']['name'] ?: $blog['gambar'];

    if ($_FILES['gambar']['name']) {
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../../backend/uploads/blog/' . $gambar);
    }

    // Update blog
    $stmt = $pdo->prepare("UPDATE blog SET judul=?, slug=?, isi=?, gambar=? WHERE id=?");
    $stmt->execute([$judul, $slug, $isi, $gambar, $id]);

    // Update tag relasi
    $pdo->prepare("DELETE FROM blog_tag WHERE blog_id=?")->execute([$id]);
    $stmtTag = $pdo->prepare("INSERT INTO blog_tag (blog_id, tag_id) VALUES (?, ?)");
    foreach ($tags as $tagId) {
        $stmtTag->execute([$id, $tagId]);
    }

    header("Location: blog_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tiny.cloud/1/l17bkui8wk8wg0e7jxwczbqlu26kl09t28ayh11jg5usgeo8/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            content_style: `
    body { font-family:Inter,sans-serif; font-size:14px; }
    p { margin: 0 0 1em; }
  `,
            forced_root_block: 'p',
            force_br_newlines: false,
            force_p_newlines: true,
            inline_styles: false,
            convert_fonts_to_spans: false,
            valid_elements: 'p,h1,h2,h3,h4,h5,h6,strong,em,b,i,ul,ol,li,blockquote,a[href|target],code,pre,br,img[src|alt|width|height],span[style],div',
        });
    </script>
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

<body class="bg-gray-900 text-white min-h-screen p-6 flex">
    <!-- Sidebar -->
    <?php include '../components/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Blog</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-2xl mx-auto text-white">
            <!-- Gambar -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Gambar (opsional)</label>
                <input type="file" name="gambar" class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700" />
                <?php if ($blog['gambar']): ?>
                    <img src="../../backend/uploads/blog/<?= $blog['gambar'] ?>" alt="Gambar Blog" class="mt-3 rounded-lg shadow-lg w-52">
                <?php endif; ?>
            </div>

            <!-- Judul -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Judul</label>
                <input type="text" name="judul" value="<?= htmlspecialchars($blog['judul']) ?>" required
                    class="w-full px-4 py-2 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>

            <!-- Isi Konten -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Konten</label>
                <textarea name="isi" id="editor" class="w-full h-64 bg-white/10 rounded-lg"><?= htmlspecialchars($blog['isi']) ?></textarea>
            </div>

            <!-- Tag -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Tag</label>
                <select name="tags[]" multiple class="w-full bg-white/10 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <?php foreach ($allTags as $tag): ?>
                        <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $selectedTags) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tag['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-sm text-gray-400">Gunakan CTRL/SHIFT untuk memilih lebih dari satu tag.</small>
            </div>

            <!-- Tombol Submit -->
            <div>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 transition-all duration-200 text-white font-medium px-6 py-2 rounded-lg">
                    Update Blog
                </button>
            </div>
        </form>
    </div>
</body>

</html>