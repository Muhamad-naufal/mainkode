<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Coming Soon - Main Kode</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- AOS -->
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Orbitron', sans-serif;
        }

        .glitch {
            position: relative;
            color: #fff;
            font-size: 3rem;
            animation: glitch 1s infinite;
        }

        @keyframes glitch {
            0% {
                text-shadow: 2px 2px #f0f, -2px -2px #0ff;
            }

            20% {
                text-shadow: -2px 2px #f0f, 2px -2px #0ff;
            }

            40% {
                text-shadow: 2px -2px #f0f, -2px 2px #0ff;
            }

            60% {
                text-shadow: -2px -2px #f0f, 2px 2px #0ff;
            }

            80% {
                text-shadow: 1px 1px #f0f, -1px -1px #0ff;
            }

            100% {
                text-shadow: 2px 2px #f0f, -2px -2px #0ff;
            }
        }
    </style>
</head>

<body class="bg-black text-white overflow-hidden">

    <section class="min-h-screen flex flex-col justify-center items-center text-center px-6 relative">
        <!-- Glow Circle -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500/20 blur-3xl rounded-full animate-pulse -z-10"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500/10 blur-2xl rounded-full animate-ping -z-10"></div>

        <h1 class="glitch mb-6" data-aos="fade-up">🚧 COMING SOON 🚧</h1>
        <p class="text-gray-300 text-lg max-w-xl mb-10" data-aos="fade-up" data-aos-delay="200">
            Halaman ini masih dalam proses pengembangan. Tunggu yaa... sesuatu yang keren dan kece bakal hadir di sini! 😎
        </p>

        <!-- Social Icons -->
        <div class="flex gap-5 text-2xl text-accent" data-aos="zoom-in" data-aos-delay="400">
            <a href="https://www.instagram.com/mainkode.id/" class="hover:text-pink-400 transition"><i class="bi bi-instagram"></i></a>
            <a href="https://www.tiktok.com/@main.kode" class="hover:text-blue-400 transition"><i class="bi bi-tiktok"></i></a>
            <a href="https://wa.me/62882008862336" class="hover:text-green-400 transition"><i class="bi bi-whatsapp"></i></a>
        </div>

        <!-- Optional Countdown -->
        <!-- <p class="mt-12 text-sm text-gray-500">Launching dalam <span id="countdown" class="text-white font-bold"></span></p> -->

    </section>

    <script>
        AOS.init();
        // Countdown (Optional)
        // const targetDate = new Date("2025-09-01T00:00:00").getTime();
        // const countdown = document.getElementById("countdown");
        // setInterval(() => {
        //   const now = new Date().getTime();
        //   const distance = targetDate - now;
        //   const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //   countdown.textContent = `${days} hari lagi!`;
        // }, 1000);
    </script>
</body>

</html>