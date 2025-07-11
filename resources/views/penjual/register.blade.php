<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Penjual</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles

    {{-- Enable dark mode by class --}}
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#16a34a',
                            dark: '#16a34a',
                        }
                    }
                }
            }
        }
    </script>
</head>

{{-- Tambahkan class `dark` untuk mengaktifkan dark mode secara manual --}}

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">

    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-xl">
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-lg p-8 space-y-6 dark:bg-gray-800 dark:border-gray-700">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-primary dark:text-amber-400">Daftar Penjual</h1>
                    <p class="text-gray-500 dark:text-gray-300 mt-1">Silakan lengkapi data untuk mendaftar sebagai
                        penjual</p>
                </div>

                <livewire:penjual-register-form />

                <p class="text-center text-sm text-gray-400 dark:text-gray-500">
                    Sudah punya akun? <a href="{{ route('filament.penjual.auth.login') }}"
                        class="text-primary hover:underline dark:text-amber-400">Login</a>
                </p>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>