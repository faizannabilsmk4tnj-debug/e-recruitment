<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dibatasi - Database Server Administrator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at center, #1e1b4b 0%, #0f172a 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 text-slate-100 antialiased">
    <div class="relative max-w-xl w-full">
        <!-- Decorative Glow Effects -->
        <div class="absolute -top-12 -left-12 w-64 h-64 bg-red-600/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-indigo-600/20 rounded-full blur-3xl animate-pulse"></div>

        <!-- Glassmorphism Card -->
        <div class="relative bg-slate-900/80 backdrop-blur-xl border border-red-500/30 rounded-3xl p-8 shadow-2xl text-center overflow-hidden">
            <!-- Animated Top Border Glow -->
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

            <!-- Lock Shield Icon -->
            <div class="mx-auto w-20 h-20 bg-red-500/10 rounded-2xl flex items-center justify-center border border-red-500/20 mb-6 relative">
                <div class="absolute inset-0 bg-red-500/5 rounded-2xl animate-ping opacity-75"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <!-- Main Heading -->
            <h1 class="text-2xl font-extrabold tracking-tight text-white mb-3">
                AKSES DIHENTIKAN OLEH DATABASE SERVER
            </h1>
            
            <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                Pengelola Database Server (DBA) telah melakukan operasi <span class="text-red-400 font-semibold">REVOKE</span> (pencabutan hak akses) pada user database Anda untuk tabel sistem.
            </p>

            <!-- Technical Detail Box -->
            <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 mb-8 text-left">
                <span class="text-[10px] font-bold text-red-400 tracking-wider uppercase block mb-1.5">Rincian Error Server (MySQL 1142)</span>
                <p class="text-xs font-mono text-slate-300 break-words leading-relaxed">
                    {{ $exception->getMessage() }}
                </p>
            </div>

            <!-- Explanation & Instructions -->
            <div class="text-slate-400 text-xs leading-relaxed space-y-3 mb-8 bg-slate-800/30 p-4 rounded-xl border border-slate-700/50">
                <p class="text-slate-300 font-semibold">Bagaimana cara memulihkan hak akses?</p>
                <p>
                    Sebagai <strong>Administrator Server Database (DBA)</strong>, Anda harus memberikan kembali hak akses SELECT/INSERT/UPDATE untuk user ini di MySQL menggunakan perintah SQL berikut:
                </p>
                <div class="bg-slate-950 p-2.5 rounded-lg text-left font-mono text-[11px] text-green-400 border border-slate-800 select-all">
                    GRANT SELECT, INSERT, UPDATE, DELETE ON e_recruitment.* TO 'faiz@gmail.com'@'localhost';
                </div>
                <p class="text-[10px]">
                    *Sesuaikan host/username sesuai dengan setelan server MySQL Anda, lalu jalankan <code class="bg-slate-900 px-1 py-0.5 rounded text-amber-400">FLUSH PRIVILEGES;</code>.
                </p>
            </div>

            <!-- Reload Button -->
            <button onclick="window.location.reload()" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-6 py-3 rounded-xl transition duration-300 shadow-md shadow-red-900/20 w-full justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 animate-spin-reverse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89H18" />
                </svg>
                Periksa Ulang Koneksi Server
            </button>
        </div>

        <!-- Footer Info -->
        <p class="text-center text-[10px] text-slate-500 mt-6">
            E-Recruitment Access Control Verification System &bull; Local Environment Mode
        </p>
    </div>
</body>
</html>
