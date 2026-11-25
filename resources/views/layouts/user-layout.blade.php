<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UniForma')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/regular/style.css">
    <script>
        try {
            const settings = JSON.parse(localStorage.getItem('uniforma.accessibility') || '{}');
            const scale = Number(settings.scale);
            if ([100, 110, 120, 130, 140, 150].includes(scale)) document.documentElement.style.fontSize = `${scale}%`;
            if (settings.contrast === true) document.documentElement.dataset.contrast = 'high';
        } catch (_) {}
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen min-w-0 flex-col bg-[#f5f7fc] font-sans antialiased text-slate-900">
    <a href="#conteudo-principal" class="sr-only focus:not-sr-only focus:fixed focus:left-3 focus:top-3 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-[#142c59] focus:shadow-lg">Ir para o conteúdo principal</a>
    @php
        $normalUser = auth('user')->user();
        $adminUser = auth('admin')->user();
        $roleName = $normalUser?->roles->first()?->name;
        $roleLabel = match ($roleName) {
            'aluno' => 'Aluno',
            'servidor' => 'Servidor',
            default => $roleName,
        };
    @endphp

    <x-accessibility-toolbar />

    @include('users.partials.public-navbar')

    <main id="conteudo-principal" tabindex="-1" class="mx-auto w-full min-w-0 max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <footer class="bg-[#102448] text-blue-100">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:grid-cols-2 sm:px-6 lg:grid-cols-[2fr_1fr_1fr] lg:px-8">
            <div><a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-white"><x-application-logo class="h-9 w-9 fill-current" />UniForma</a><p class="mt-4 max-w-sm text-sm leading-7">Um espaço para propor, apoiar, ministrar e participar de formações criadas pela comunidade.</p></div>
            <nav aria-label="Explorar" class="grid content-start gap-3 text-sm"><h2 class="font-bold text-white">Explorar</h2><a href="{{ route('home') }}">Início</a><a href="{{ route('home') }}#submissoes">Submissões</a><a href="{{ route('offers.index') }}">Formações aprovadas</a></nav>
            <nav aria-label="Informações" class="grid content-start gap-3 text-sm"><h2 class="font-bold text-white">Informações</h2><a href="{{ route('about') }}">Sobre o projeto</a><a href="{{ route('faq') }}">Perguntas frequentes</a>@if (auth('admin')->check())<a href="{{ route('admin.dashboard') }}">Painel administrativo</a>@endif</nav>
        </div>
        <div class="border-t border-white/10 px-4 py-4 text-center text-xs text-blue-200">© {{ date('Y') }} UniForma</div>
    </footer>

    @if (session('status'))
        <x-toast type="success" :message="session('status')" />
    @endif
    @if (session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif
</body>
</html>
