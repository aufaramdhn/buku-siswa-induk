<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Buku Induk Siswa</title>
    <link rel="icon" type="image/png" href="/images/logo_smp_cisewu.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas text-neutral-900 flex items-center justify-center min-h-screen p-4 font-sans select-none">

    <div class="w-full max-w-md bg-white border border-neutral-200 rounded-2xl p-8 shadow-sm text-center flex flex-col items-center">
        <img src="/images/logo_smp_cisewu.png" alt="Logo SMPN 1 Cisewu" style="width: 72px; height: 72px;" class="object-contain mb-4" />
        
        <span class="inline-block px-3.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold tracking-wider font-sans mb-3">
            KODE ERROR 403
        </span>

        <h1 class="text-xl font-bold text-neutral-900 tracking-tight font-sans mb-2">Akses Ditolak</h1>
        
        <p class="text-xs text-neutral-500 font-sans leading-relaxed mb-6">
            Anda tidak memiliki hak akses atau izin yang cukup untuk membuka halaman ini. Silakan hubungi Administrator jika ini adalah kesalahan.
        </p>

        <div class="grid grid-cols-2 gap-3 w-full">
            <button onclick="window.history.back()" class="w-full px-4 py-2.5 bg-neutral-100 hover:bg-neutral-200 active:bg-neutral-300 text-neutral-800 font-semibold rounded-xl text-xs sm:text-sm transition-colors font-sans cursor-pointer text-center">
                Kembali
            </button>
            <a href="{{ route('dashboard') }}" class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold rounded-xl text-xs sm:text-sm transition-colors font-sans cursor-pointer text-center inline-block">
                Ke Dasbor Utama
            </a>
        </div>
    </div>

</body>
</html>
