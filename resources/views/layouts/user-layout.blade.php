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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-900">
    @php
        $normalUser = auth('user')->user();
        $adminUser = auth('admin')->user();
        $roleName = $normalUser?->roles->first()?->name;
        $roleLabel = match ($roleName) {
            'discente' => 'Discente',
            'docente' => 'Docente',
            'tecnico' => 'Técnico',
            default => $roleName,
        };
    @endphp

    <header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 bg-[#16385B] shadow-md">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-white">
                <x-application-logo class="h-10 w-10 fill-current" />
                <span class="text-2xl font-bold tracking-wide">UniForma</span>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-medium text-white lg:flex" aria-label="Navegação principal">
                <a href="{{ route('home') }}" class="transition hover:text-blue-200">Início</a>
                <a href="{{ route('user.submissions.showSub') }}#submissoes" class="transition hover:text-blue-200">Submissões</a>
                <span class="cursor-not-allowed text-white/45" aria-disabled="true" title="Em breve">Sobre Nós <small>Em breve</small></span>
                <span class="cursor-not-allowed text-white/45" aria-disabled="true" title="Em breve">Cursos <small>Em breve</small></span>
                @if ($adminUser)
                    <span class="cursor-not-allowed text-white/45" aria-disabled="true" title="Disponível para usuários comuns">Nova Demanda</span>
                @else
                    <a href="{{ route('user.submissions.create') }}" class="transition hover:text-blue-200">Nova Demanda</a>
                @endif
            </nav>

            <div class="flex items-center gap-3">
                @if ($normalUser)
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 rounded-lg px-2 py-2 text-left text-white transition hover:bg-white/10">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-white/15 font-semibold">{{ mb_strtoupper(mb_substr($normalUser->name, 0, 1)) }}</span>
                                <span class="hidden sm:block">
                                    <span class="block max-w-36 truncate text-sm font-semibold">{{ $normalUser->name }}</span>
                                    <span class="block text-xs text-blue-200">{{ $roleLabel }}</span>
                                </span>
                                <i class="ph ph-caret-down hidden sm:block"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="border-b border-gray-100 px-4 py-3">
                                <p class="truncate text-sm font-semibold text-gray-800">{{ $normalUser->name }}</p>
                                <p class="truncate text-xs text-gray-500">{{ $normalUser->email }}</p>
                                <p class="mt-1 text-xs font-medium text-primary-500">{{ $roleLabel }}</p>
                            </div>
                            <x-dropdown-link :href="route('user.profile.edit')"><i class="ph ph-user me-2"></i>Meu perfil</x-dropdown-link>
                            <x-dropdown-link :href="route('user.submissions.index')"><i class="ph ph-files me-2"></i>Minhas Demandas</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"><i class="ph ph-sign-out me-2"></i>Sair</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @elseif ($adminUser)
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 rounded-lg px-2 py-2 text-white transition hover:bg-white/10">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-white/15 font-semibold">{{ mb_strtoupper(mb_substr($adminUser->name, 0, 1)) }}</span>
                                <span class="hidden max-w-36 truncate text-sm font-semibold sm:block">{{ $adminUser->name }}</span>
                                <i class="ph ph-caret-down hidden sm:block"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="border-b border-gray-100 px-4 py-3">
                                <p class="truncate text-sm font-semibold text-gray-800">{{ $adminUser->name }}</p>
                                <p class="truncate text-xs text-gray-500">{{ $adminUser->email }}</p>
                            </div>
                            <x-dropdown-link :href="route('admin.dashboard')"><i class="ph ph-gauge me-2"></i>Painel administrativo</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.profile.edit')"><i class="ph ph-user me-2"></i>Meu perfil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"><i class="ph ph-sign-out me-2"></i>Sair</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="hidden items-center gap-2 sm:flex">
                        <a href="{{ route('register') }}" class="rounded-lg border border-white/40 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">Registrar-se</a>
                        <a href="{{ route('login') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-[#16385B] transition hover:bg-blue-50">Entrar</a>
                    </div>
                @endif

                <button @click="mobileOpen = !mobileOpen" class="rounded-lg p-2 text-white hover:bg-white/10 lg:hidden" aria-label="Abrir menu">
                    <i class="ph text-2xl" :class="mobileOpen ? 'ph-x' : 'ph-list'"></i>
                </button>
            </div>
        </div>

        <nav x-show="mobileOpen" x-transition class="border-t border-white/10 px-4 py-4 text-sm text-white lg:hidden" style="display:none">
            <div class="mx-auto grid max-w-7xl gap-2">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 hover:bg-white/10">Início</a>
                <a href="{{ route('home') }}#submissoes" class="rounded-lg px-3 py-2 hover:bg-white/10">Submissões</a>
                @if (! $adminUser)<a href="{{ route('user.submissions.create') }}" class="rounded-lg px-3 py-2 hover:bg-white/10">Nova Demanda</a>@endif
                <span class="px-3 py-2 text-white/45" aria-disabled="true">Sobre Nós — Em breve</span>
                <span class="px-3 py-2 text-white/45" aria-disabled="true">Cursos — Em breve</span>
                @guest('user')
                    @guest('admin')
                        <div class="mt-2 grid grid-cols-2 gap-2 border-t border-white/10 pt-4">
                            <a href="{{ route('register') }}" class="rounded-lg border border-white/40 px-4 py-2 text-center font-semibold">Registrar-se</a>
                            <a href="{{ route('login') }}" class="rounded-lg bg-white px-4 py-2 text-center font-semibold text-[#16385B]">Entrar</a>
                        </div>
                    @endguest
                @endguest
            </div>
        </nav>
    </header>

    <main class="mx-auto min-h-[calc(100vh-5rem)] max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @if (session('status'))
        <x-toast type="success" :message="session('status')" />
    @endif
    @if (session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif
</body>
</html>
