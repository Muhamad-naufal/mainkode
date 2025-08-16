<?php
require_once '../connection/db.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM tag WHERE id = ?");
$stmt->execute([$id]);

header("Location: ../../admin/page/tag_index.php");
exit;
