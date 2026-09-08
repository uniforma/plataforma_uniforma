<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UniForma')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    <header class="bg-[#16385B] shadow-md">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-8">

            <!-- Logo -->
            <a href="#" class="text-4xl font-bold text-white">
                UniForma
            </a>

            <!-- Menu -->
            <nav class="hidden items-center gap-8 text-sm font-medium text-white md:flex">
                <a href="#" class="transition hover:text-blue-200">Submissões</a>
                <a href="#" class="transition hover:text-blue-200">Sobre Nós</a>
                <a href="#" class="transition hover:text-blue-200">Cursos</a>
                <a href="#" class="transition hover:text-blue-200">Nova Demanda</a>
            </nav>

            <!-- Ícones -->
            <div class="flex items-center gap-5 text-white">

                <button class="hover:text-blue-200">
                    🔍
                </button>

                <button class="hover:text-blue-200">
                    👤
                </button>

            </div>

        </div>
    </header>

    <main class="mx-auto max-w-7xl p-8">

        @yield('content')

    </main>

</body>
</html>