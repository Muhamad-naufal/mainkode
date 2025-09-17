<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Code Playground - Main Kode</title>

    <link rel="icon" href="../assets/images/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="../assets/css/custom.css" />
</head>

<body class="bg-gradient-to-b from-[#0f0f0f] via-[#1a1a1a] to-[#0f0f0f] text-white min-h-screen mb-16">

    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>
    <div class="mt-20 flex flex-col items-center gap-4">
        <h1 class="text-2xl font-bold text-center bg-gradient-to-r from-[#007acc] to-[#005a99] bg-clip-text text-transparent drop-shadow-lg tracking-wide">
            Code Playground
        </h1>
        <div class="h-1 w-24 bg-gradient-to-r from-[#007acc] to-[#005a99] rounded-full mt-1"></div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4 h-[calc(100vh-80px)]">
        <!-- Editor -->
        <div class="flex flex-col gap-3 bg-[#1e1e1e] rounded-xl p-4 shadow-lg">
            <div>
                <label class="block text-sm mb-1">HTML</label>
                <textarea id="html-code" class="w-full h-28 rounded-lg p-2 bg-[#252526] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#007acc]">
<h1>Hello World</h1>
                </textarea>
            </div>

            <div>
                <label class="block text-sm mb-1">CSS</label>
                <textarea id="css-code" class="w-full h-28 rounded-lg p-2 bg-[#252526] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#007acc]">
h1 { color: red; }
                </textarea>
            </div>

            <div>
                <label class="block text-sm mb-1">JavaScript</label>
                <textarea id="js-code" class="w-full h-28 rounded-lg p-2 bg-[#252526] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#007acc]">
console.log("Hello from JS");
                </textarea>
            </div>

            <button onclick="runCode()" class="w-full py-2 rounded-lg bg-[#007acc] hover:bg-[#005a99] transition-all font-semibold">
                <i class="bi bi-play-fill"></i> Run
            </button>
        </div>

        <!-- Output -->
        <div class="bg-white rounded-xl overflow-hidden shadow-lg h-[300px] lg:h-full">
            <iframe id="output" class="w-full h-full border-none"></iframe>
        </div>

    </div>

    <script>
        function runCode() {
            const html = document.getElementById("html-code").value;
            const css = "<style>" + document.getElementById("css-code").value + "</style>";
            const js = "<script>" + document.getElementById("js-code").value + "<\/script>";
            const output = document.getElementById("output");
            output.srcdoc = html + css + js;
        }
    </script>

</body>

</html>