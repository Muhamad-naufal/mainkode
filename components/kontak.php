<section class="min-h-screen w-full bg-gradient-to-b from-[#0f172a] via-[#1e293b] to-[#0f172a] text-white py-24 px-6 md:px-12" id="kontak">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center" data-aos="fade-up">

        <!-- Text Info -->
        <div>
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6">
                Kontak <span class="text-accent">Main Kode</span>
            </h2>
            <p class="text-lg text-gray-300 mb-6 leading-relaxed">
                Ada ide, pertanyaan, atau kolaborasi seru?
                Jangan ragu buat hubungi kami!
                Tim <span class="text-accent font-medium">Main Kode</span> siap mendengar kamu 🌟
            </p>

            <ul class="space-y-4 text-gray-300 text-sm">
                <li><i class="bi bi-envelope text-accent"></i> &nbsp; mainkode4@gmail.com</li>
                <li><i class="bi bi-phone text-accent"></i> &nbsp; +62 882-0088-62336</li>
                <li><i class="bi bi-geo-alt text-accent"></i> &nbsp; Purworejo, Indonesia</li>
            </ul>

            <!-- Socials -->
            <div class="flex space-x-4 mt-6">
                <a href="https://www.instagram.com/mainkode.id/" class="hover:text-green-400"><i class="bi bi-instagram"></i></a>
                <a href="https://www.tiktok.com/@main.kode" class="hover:text-green-400"><i class="bi bi-tiktok"></i></a>
                <a href="https://www.youtube.com/@mainkodechannel" class="hover:text-green-400"><i class="bi bi-youtube"></i></a>
            </div>
        </div>

        <!-- Contact Form -->
        <form action="backend/user/kirim_pesan.php" method="POST" class="bg-white/10 backdrop-blur rounded-2xl p-8 border border-white/20 shadow-xl space-y-4">
            <div>
                <label class="block text-sm mb-1 text-white">Nama</label>
                <input type="text" name="nama" required class="w-full rounded-lg px-4 py-2 bg-white/5 text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm mb-1 text-white">Email</label>
                <input type="email" name="email" required class="w-full rounded-lg px-4 py-2 bg-white/5 text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm mb-1 text-white">Pesan</label>
                <textarea name="pesan" rows="5" required class="w-full rounded-lg px-4 py-2 bg-white/5 text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
            </div>
            <button type="submit" class="w-full bg-accent text-white font-semibold py-2 rounded-lg hover:bg-orange-500 transition">
                Kirim Pesan
            </button>
        </form>

    </div>
</section>