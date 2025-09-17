<header x-data="{ mobileMenuOpen: false, fiturOpen: false, fiturMobileOpen: false }" class="w-full bg-[#0f172a] fixed top-0 z-50 border-b border-slate-700 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <!-- Logo -->
        <a href="../index.php" class="text-2xl font-extrabold text-[#F26E1C] tracking-wide flex items-center gap-2">
            <img src="../assets/images/logo.png" alt="MainKode Logo" class="h-9 w-9">
            Main<span class="text-white">Kode</span>
        </a>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex space-x-8 text-sm font-medium text-white items-center">
            <a href="../index.php" class="hover:text-[#F26E1C] transition">Home</a>

            <!-- Dropdown Fitur Desktop -->
            <div class="relative" @mouseenter="fiturOpen = true" @mouseleave="fiturOpen = false">
                <button class="hover:text-[#F26E1C] transition flex items-center gap-1">
                    Fitur
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="fiturOpen" x-transition
                    class="absolute mt-2 w-48 bg-white text-gray-800 rounded-lg shadow-lg py-2 z-50"
                    style="display: none;">
                    <a href="blog.php" class="block px-4 py-2 hover:bg-gray-100">Blog</a>
                    <a href="code_playground.php" class="block px-4 py-2 hover:bg-gray-100">Code Playground</a>
                    <a href="project.php" class="block px-4 py-2 hover:bg-gray-100">Project Showcase</a>
                </div>
            </div>
        </nav>

        <!-- Mobile Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden focus:outline-none text-white text-2xl">
            <template x-if="!mobileMenuOpen">
                <i class="bi bi-list"></i>
            </template>
            <template x-if="mobileMenuOpen">
                <i class="bi bi-x-lg"></i>
            </template>
        </button>
    </div>

    <!-- Mobile Nav Slide From Right -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
        class="md:hidden bg-[#0f172a] absolute top-16 right-0 w-2/3 sm:w-1/2 h-screen text-white px-6 py-6 space-y-4 shadow-lg">

        <a href="../index.php" class="block text-base hover:text-[#F26E1C]">Home</a>

        <!-- Dropdown Fitur Mobile -->
        <div>
            <button @click="fiturMobileOpen = !fiturMobileOpen" class="w-full flex justify-between items-center text-base hover:text-[#F26E1C]">
                Fitur
                <svg :class="{ 'rotate-180': fiturMobileOpen }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="fiturMobileOpen" x-transition class="ml-4 mt-2 space-y-2" style="display: none;">
                <a href="blog.php" class="block text-sm hover:text-[#F26E1C]">Blog</a>
                <a href="code_playground.php" class="block text-sm hover:text-[#F26E1C]">Code Playground</a>
                <a href="project.php" class="block text-sm hover:text-[#F26E1C]">Project Showcase</a>
            </div>
        </div>
    </div>
</header>