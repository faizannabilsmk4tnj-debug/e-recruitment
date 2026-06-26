<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Dinonaktifkan - Ecogreen Oleochemicals</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 max-w-md w-full p-8 text-center">
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Akun Dinonaktifkan</h1>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
            Akun Anda telah dinonaktifkan oleh HR Master. Anda tidak lagi memiliki hak akses ke dalam HR Panel PT Ecogreen Oleochemicals.
        </p>
        <button onclick="handleOk()" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl transition-colors duration-200 text-sm shadow-lg shadow-red-100">
            Kembali ke Login
        </button>
    </div>

    <script>
        alert('Akun Anda telah dinonaktifkan oleh HR Master.');
        window.location.href = '/hr/login';

        function handleOk() {
            window.location.href = '/hr/login';
        }
    </script>
</body>
</html>
