<?php
require_once '../connection/db.php';

if (!isset($_GET['id'])) die('ID tidak ditemukan');
$id = $_GET['id'];

$pdo->prepare("DELETE FROM blog WHERE id = ?")->execute([$id]);

header("Location: ../../admin/page/blog_index.php");
exit;
