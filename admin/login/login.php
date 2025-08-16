<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Main Kode</title>
    <link rel="icon" href="assets/images/logo.png" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            font-family: 'Inter', sans-serif;
        }
    </style>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/images/logo.png">

</head>

<body class="min-h-screen flex items-center justify-center">

    <div class="bg-white/5 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-md text-white" data-aos="fade-up">
        <div class="text-center mb-6">
            <img src="../assets/images/logo.png" alt="Main Kode" class="w-14 mx-auto mb-2 rounded-full border border-white/10 shadow">
            <h1 class="text-2xl font-bold tracking-wide">Login Admin</h1>
            <p class="text-sm text-gray-400">Main Kode Management System</p>
        </div>
        <form action="../../backend/admin/proccess_login.php" method="POST" class="space-y-5">
            <div>
                <label class="text-sm mb-1 block">Username</label>
                <div class="relative">
                    <input type="text" name="username" required placeholder="Masukkan username"
                        class="w-full px-4 py-3 bg-white/10 text-white rounded-xl border border-white/10 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
                    <i class="bi bi-person absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="text-sm mb-1 block">Password</label>
                <div class="relative">
                    <input type="password" name="password" required placeholder="Masukkan password"
                        class="w-full px-4 py-3 bg-white/10 text-white rounded-xl border border-white/10 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
                    <i class="bi bi-lock-fill absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-xl font-semibold transition duration-200">Masuk</button>
        </form>
        <p class="mt-5 text-center text-xs text-gray-500">© 2025 Main Kode</p>
    </div>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>