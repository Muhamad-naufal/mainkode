<header x-data="{ mobileMenuOpen: false, fiturOpen: false }" class="w-full bg-main border-b border-slate-700 fixed top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <!-- Logo -->
        <a href="#" class="flex items-center gap-2">
            <img src="assets/images/logo.png" alt="MainKode Logo" class="h-10 w-10" />
            <span class="text-xl font-bold text-[#F26E1C]">Main Kode</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-8 text-sm font-medium text-white items-center">
            <a href="#" class="hover:text-[#F26E1C] transition">Beranda</a>
            <a href="#about" class="hover:text-[#F26E1C] transition">Tentang</a>

            <!-- Dropdown Fitur -->
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
                    <a href="#artikel" class="block px-4 py-2 hover:bg-gray-100">Blog</a>
                    <a href="#code_playground" class="block px-4 py-2 hover:bg-gray-100">Code Playground</a>
                    <a href="#project_showcase" class="block px-4 py-2 hover:bg-gray-100">Project Showcase</a>
                </div>
            </div>

            <a href="#kontak" class="hover:text-[#F26E1C] transition">Kontak</a>
        </nav>

        <!-- Mobile Button -->
        <button @click="mobileMenuOpen = true" class="md:hidden focus:outline-none">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-0 z-40 bg-black bg-opacity-50 flex justify-end md:hidden"
        @click.away="mobileMenuOpen = false"
        style="display: none;">
        <div class="w-64 bg-main h-full p-6 flex flex-col space-y-4 shadow-lg" x-data="{ fiturMobileOpen: false }">
            <div class="flex justify-between items-center mb-6">
                <span class="text-xl font-bold text-[#F26E1C]">Main Kode</span>
                <button @click="mobileMenuOpen = false" class="text-white hover:text-[#F26E1C]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <a href="#" class="block py-2 text-white hover:text-[#F26E1C]">Beranda</a>
            <a href="#about" class="block py-2 text-white hover:text-[#F26E1C]">Tentang</a>

            <!-- Dropdown Fitur Mobile -->
            <div>
                <button @click="fiturMobileOpen = !fiturMobileOpen" class="w-full flex justify-between items-center py-2 text-white hover:text-[#F26E1C]">
                    Fitur
                    <svg :class="{ 'rotate-180': fiturMobileOpen }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="fiturMobileOpen" x-transition class="ml-4 mt-2 space-y-2" style="display: none;">
                    <a href="#artikel" class="block py-1 text-white hover:text-[#F26E1C]">Blog</a>
                    <a href="#code_playground" class="block py-1 text-white hover:text-[#F26E1C]">Code Playground</a>
                    <a href="#project_showcase" class="block py-1 text-white hover:text-[#F26E1C]">Project Showcase</a>
                </div>
            </div>

            <a href="#kontak" class="block py-2 text-white hover:text-[#F26E1C]">Kontak</a>
        </div>
    </div>
</header>