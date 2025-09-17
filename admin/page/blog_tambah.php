<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

// Ambil semua tag
$tags = $pdo->query("SELECT * FROM tag ORDER BY nama")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
    $isi = $_POST['isi'];
    $tag_ids = $_POST['tags'] ?? [];

    // Upload gambar (validasi dasar)
    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $namaGambar = time() . '_' . basename($_FILES['gambar']['name']);
        $target = '../../backend/uploads/blog/' . $namaGambar;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $gambar = $namaGambar;
        }
    }

    // Simpan blog
    $stmt = $pdo->prepare("INSERT INTO blog (judul, slug, isi, gambar) VALUES (?, ?, ?, ?)");
    $stmt->execute([$judul, $slug, $isi, $gambar]);

    $blog_id = $pdo->lastInsertId();

    // Simpan relasi tag
    $stmtTag = $pdo->prepare("INSERT INTO blog_tag (blog_id, tag_id) VALUES (?, ?)");
    foreach ($tag_ids as $tag_id) {
        $stmtTag->execute([$blog_id, $tag_id]);
    }

    header("Location: blog_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/l17bkui8wk8wg0e7jxwczbqlu26kl09t28ayh11jg5usgeo8/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            forced_root_block: 'p',
            force_br_newlines: false,
            force_p_newlines: true,
            inline_styles: false,
            convert_fonts_to_spans: false,
            valid_elements: 'p,h1,h2,h3,h4,h5,h6,strong,em,b,i,ul,ol,li,blockquote,a[href|target],code,pre,br,img[src|alt|width|height],span[style],div'
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

<body class="bg-gray-950 text-white flex">
    <?php include '../components/sidebar.php'; ?>

    <main class="flex-1 p-8 md:ml-64">
        <div class="max-w-3xl">
            <h1 class="text-2xl font-bold mb-6">Tambah Blog Baru</h1>
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white/5 p-6 rounded-xl shadow-lg">

                <!-- Gambar -->
                <div>
                    <label class="block mb-2 font-semibold">Gambar Sampul</label>
                    <input type="file" name="gambar" accept="image/*" class="text-sm text-gray-300" />
                </div>

                <!-- Judul -->
                <div>
                    <label class="block mb-2 font-semibold">Judul</label>
                    <input type="text" name="judul" required
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Konten -->
                <div>
                    <label class="block mb-2 font-semibold">Konten</label>
                    <textarea id="editor" name="isi" class="w-full h-64 rounded bg-white/10 text-white"></textarea>
                </div>

                <!-- Tag -->
                <div>
                    <label class="block mb-2 font-semibold">Tag</label>
                    <div class="flex flex-wrap gap-3">
                        <?php foreach ($tags as $tag): ?>
                            <label class="flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full hover:bg-blue-700 transition cursor-pointer shadow-sm">
                                <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" class="accent-blue-500 w-4 h-4 focus:ring-blue-400">
                                <span class="text-sm"><?= htmlspecialchars($tag['nama']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
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