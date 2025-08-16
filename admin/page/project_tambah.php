<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../backend/connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $link        = $_POST['link'];
    $tech_stack  = $_POST['tech_stack'];

    // Upload gambar
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $target    = '../../backend/uploads/projects/' . $imageName;
        if (!is_dir('../../backend/uploads/projects/')) {
            mkdir('../../backend/uploads/projects/', 0777, true);
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $imageName;
        }
    }

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, link, tech_stack) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $image, $link, $tech_stack]);

    header("Location: project_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/l17bkui8wk8wg0e7jxwczbqlu26kl09t28ayh11jg5usgeo8/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description',
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
            <h1 class="text-2xl font-bold mb-6">Tambah Project Baru</h1>
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white/5 p-6 rounded-xl shadow-lg">

                <!-- Gambar -->
                <div>
                    <label class="block mb-2 font-semibold">Gambar Project</label>
                    <input type="file" name="image" accept="image/*" class="text-sm text-gray-300" />
                </div>

                <!-- Judul -->
                <div>
                    <label class="block mb-2 font-semibold">Judul Project</label>
                    <input type="text" name="title" required
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block mb-2 font-semibold">Deskripsi</label>
                    <textarea id="description" name="description" class="w-full h-64 rounded bg-white/10 text-white"></textarea>
                </div>

                <!-- Link Project -->
                <div>
                    <label class="block mb-2 font-semibold">Link Project</label>
                    <input type="url" name="link"
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Tech Stack -->
                <div>
                    <label class="block mb-2 font-semibold">Tech Stack</label>
                    <input type="text" name="tech_stack" placeholder="Contoh: PHP, MySQL, Tailwind"
                        class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
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