<?php

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Main Kode - Blog</title>

    <!-- Icon -->
    <link rel="icon" href="assets/images/logo.png" type="image/png" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS -->
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet" />

    <!-- Highlight.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/custom.css" />
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <?php include 'components/header.php'; ?>

    <!-- Hero -->
    <?php include 'components/hero.php'; ?>

    <!-- About Section -->
    <?php include 'components/about.php'; ?>

    <!-- Blog Posts -->
    <?php include 'components/post.php'; ?>

    <!-- Code Playground Section -->
    <?php include 'components/code_playground.php' ?>

    <!-- Project Showcase Section -->
    <?php include 'components/project_showcase.php' ?>

    <!-- Contact Section -->
    <?php include 'components/kontak.php'; ?>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>