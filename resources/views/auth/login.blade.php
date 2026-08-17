<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Buku Induk Siswa</title>
    <link rel="icon" type="image/png" href="/images/logo_smp_cisewu.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas text-neutral-900 flex items-center justify-center min-h-screen p-4 font-sans select-none">

    <div class="w-full max-w-md bg-white border border-neutral-200 rounded-xl p-8 shadow-sm">
        <div class="flex flex-col items-center mb-8">
            <img src="/images/logo_smp_cisewu.png" alt="Logo SMPN 1 Cisewu" class="w-14 h-14 object-contain mb-4" />
            <h1 class="text-xl font-bold text-neutral-900 tracking-tight font-sans text-center">Buku Induk Siswa</h1>
            <p class="text-xs text-neutral-400 font-sans mt-1 text-center">Masuk ke sistem tata usaha sekolah</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="flex flex-col gap-5">
                <x-form.form-group label="Nama Pengguna / Email" name="username">
                    <x-form.input name="username" type="text" placeholder="Masukkan username atau email" value="{{ old('username') }}" required />
                </x-form.form-group>

                <x-form.form-group label="Kata Sandi" name="password">
                    <x-form.input name="password" type="password" placeholder="••••••••" required />
                </x-form.form-group>

                <div class="flex items-center justify-between">
                    <x-form.checkbox name="remember" label="Ingat Saya" :checked="old('remember') ? true : false" />
                </div>

                <x-ui.button type="submit" variant="primary" class="w-full">
                    Masuk ke Dasbor
                </x-ui.button>
            </div>
        </form>
    </div>

</body>
</html>
