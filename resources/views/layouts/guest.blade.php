<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UniForma') }}</title>
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
<body class="min-h-screen bg-[#f5f7fc] font-sans text-slate-900 antialiased {{ request()->routeIs('register') ? 'lg:overflow-hidden' : '' }}">
    <a href="#guest-content" class="sr-only focus:not-sr-only focus:fixed focus:left-3 focus:top-3 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-[#142c59]">Ir para o formulário</a>
    <x-accessibility-toolbar />
    <div class="grid min-h-screen lg:grid-cols-[minmax(0,1fr)_minmax(460px,0.9fr)] {{ request()->routeIs('register') ? 'lg:min-h-[calc(100vh-3.5rem)]' : '' }}">
        <div class="relative hidden overflow-hidden bg-[#142c59] p-10 text-white lg:flex lg:flex-col lg:justify-between xl:p-16 {{ request()->routeIs('register') ? 'lg:h-[calc(100vh-3.5rem)]' : '' }}">
            <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full border border-white/15"></div>
            <div class="pointer-events-none absolute -bottom-32 left-16 h-[30rem] w-[30rem] rounded-full border border-white/15"></div>
            <div class="pointer-events-none absolute right-14 top-1/3 h-36 w-36 rotate-12 rounded-3xl bg-[#765fe9]/50 blur-sm"></div>
            <a href="{{ route('home') }}" class="relative flex items-center gap-3 text-2xl font-bold"><x-application-logo class="h-10 w-10 fill-current" />UniForma</a>
            <div class="relative max-w-xl">
                <span class="inline-flex rounded-full border border-white/25 px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#4be0bc]">Aprender e compartilhar</span>
                <h2 class="mt-6 text-4xl font-bold leading-tight xl:text-5xl">Ideias que aproximam pessoas e conhecimento.</h2>
                <p class="mt-6 max-w-lg text-lg leading-8 text-blue-100">Participe das demandas da comunidade, apoie novas formações e compartilhe o que você sabe.</p>
                <div class="mt-10 grid max-w-md grid-cols-3 gap-3" aria-hidden="true">
                    <span class="h-24 rounded-2xl bg-[#765fe9]"></span><span class="h-24 rounded-2xl bg-[#42d9ad]"></span><span class="h-24 rounded-2xl bg-white/15"></span>
                </div>
            </div>
            <p class="relative text-sm text-blue-200">Uma comunidade que cresce junto.</p>
        </div>
        <div id="guest-content" tabindex="-1" class="flex min-h-screen min-w-0 items-center justify-center px-4 py-10 sm:px-8 {{ request()->routeIs('register') ? 'lg:h-[calc(100vh-3.5rem)] lg:min-h-0 lg:items-start lg:overflow-y-auto' : '' }}">
            <div class="w-full max-w-xl">
                <a href="{{ route('home') }}" class="mb-7 flex items-center justify-center gap-2 text-xl font-bold text-[#142c59] lg:hidden"><x-application-logo class="h-9 w-9 fill-current" />UniForma</a>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_24px_80px_-45px_rgba(20,44,89,.35)] sm:p-10">{{ $slot }}</div>
                <p class="mt-6 text-center text-xs text-slate-500">UniForma · Conectando ideias e oportunidades de formação</p>
            </div>
        </div>
    </div>
    @if (session('status')) <x-toast type="success" :message="session('status')" /> @endif
    @if (session('error')) <x-toast type="error" :message="session('error')" /> @endif
</body>
</html>
