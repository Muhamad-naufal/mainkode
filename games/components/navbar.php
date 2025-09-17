<!-- NAVBAR -->
<nav class="w-full border-b border-gray-800 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between h-auto md:h-16 py-3 md:py-0 gap-3">

            <!-- Left: Logo -->
            <a href="index.php" class="flex items-center gap-3">
                <img src="assets/logo.png" alt="logo" class="w-10 h-10 rounded" />
                <span class="font-bold text-xl tracking-wide text-white">ENGaming</span>
            </a>

            <!-- Right: Search -->
            <form action="index.php" method="get" class="flex w-full md:w-auto">
                <input type="text" name="q" placeholder="Cari game..."
                    value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>"
                    class="flex-1 md:flex-none px-4 py-2 rounded-l bg-gray-800 border border-gray-700 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button type="submit"
                    class="px-4 py-2 rounded-r bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                    Search
                </button>
            </form>

        </div>
    </div>
</nav>