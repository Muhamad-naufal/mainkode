<?php
// --- Database connection ---
include '../backend/connection/db.php';
// --- Pagination setup ---
$limit = 15; // jumlah game per halaman
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// --- Search setup ---
$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$where = "";
$params = [];

if ($keyword !== '') {
  $where = "WHERE g.title LIKE :keyword";
  $params[':keyword'] = "%$keyword%";
}

// --- Hitung total data ---
$stmt = $pdo->prepare("SELECT COUNT(*) FROM games g $where");
$stmt->execute($params);
$total = $stmt->fetchColumn();
$total_pages = ceil($total / $limit);

// --- Ambil data games (all) ---
$sql = "SELECT g.* FROM games g $where ORDER BY g.created_at DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) {
  $stmt->bindValue($k, $v);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$games = $stmt->fetchAll();

// --- Ambil exclusive ---
$sqlexclusive = "SELECT * FROM games WHERE is_exclusive = 1 ORDER BY id DESC LIMIT 5";
$exclusive = $pdo->query($sqlexclusive)->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ENGaming - Website Download Game Gratis</title>

  <!-- Bootstrap (CDN for quick prototyping) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Favicon (placeholder) -->
  <link rel="icon" type="image/x-icon" href="assets/logo.png" />

  <!-- Tailwind (CDN for quick prototyping) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .steam-dark {
      background: linear-gradient(180deg, #0b0f14 0%, #0a0d11 100%);
    }

    .search-input {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      color: #ddd;
    }
  </style>
</head>

<body class="steam-dark text-white min-h-screen mb-10">

  <!-- NAVBAR -->
  <?php include 'components/navbar.php'; ?>

  <!-- List Games -->
  <?php include 'components/list.php'; ?>

</body>

</html>