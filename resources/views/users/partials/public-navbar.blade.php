@php
    $navLinks = [
        ['label' => 'Início', 'href' => route('home'), 'active' => request()->routeIs('home'), 'icon' => 'ph-house'],
        ['label' => 'Demandas', 'href' => route('home').'#submissoes', 'active' => request()->routeIs('user.submissions.showSub'), 'icon' => 'ph-files'],
        ['label' => 'Submissões aprovadas','href' => route('submissions.approved'),'active' => request()->routeIs('submissions.approved'),'icon' => 'ph-seal-check',],
        ['label' => 'Formações', 'href' => route('offers.index'), 'active' => request()->routeIs('offers.*'), 'icon' => 'ph-graduation-cap'],
        ['label' => 'Sobre', 'href' => route('about'), 'active' => request()->routeIs('about'), 'icon' => 'ph-info'],
        ['label' => 'Perguntas frequentes', 'href' => route('faq'), 'active' => request()->routeIs('faq'), 'icon' => 'ph-question'],
    ];
@endphp

<header x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false" class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur-lg">
    <div class="mx-auto flex min-h-18 max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="inline-flex shrink-0 items-center gap-2.5 rounded-lg text-[#142c59] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700" aria-label="UniForma — página inicial">
            <x-application-logo class="h-10 w-10 shrink-0" />
            <span class="text-xl font-bold tracking-tight sm:text-2xl">UniForma</span>
        </a>

        <nav class="hidden items-center gap-0.5 rounded-full border border-slate-200 bg-slate-50 p-1 text-sm font-semibold text-slate-600 xl:flex" aria-label="Navegação principal">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}" @if ($link['active']) aria-current="page" @endif class="rounded-full px-3.5 py-2.5 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 {{ $link['active'] ? 'bg-[#142c59] text-white shadow-sm' : 'hover:bg-white hover:text-[#142c59]' }}">{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2 sm:gap-3">
            @if (! $adminUser)
                <a href="{{ $normalUser ? route('user.submissions.create') : route('login', ['redirect' => route('user.submissions.create', absolute: false)]) }}" class="hidden items-center gap-2 rounded-xl bg-[#3bd5aa] px-4 py-2.5 text-sm font-bold text-[#142c59] shadow-sm transition hover:bg-[#6ee6c4] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 xl:inline-flex"><i class="ph ph-plus-circle text-lg" aria-hidden="true"></i>Nova demanda</a>
            @endif

            @if ($normalUser)
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-1.5 text-left text-[#142c59] transition hover:border-blue-300 hover:bg-blue-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700" aria-label="Menu da conta de {{ $normalUser->name }}">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-primary-50 font-bold text-primary-600">{{ mb_strtoupper(mb_substr($normalUser->name, 0, 1)) }}</span>
                            <span class="hidden max-w-28 truncate text-xs font-semibold 2xl:block">{{ $normalUser->name }}</span><i class="ph ph-caret-down hidden text-xs 2xl:block" aria-hidden="true"></i>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="border-b border-slate-100 px-4 py-3"><p class="truncate text-sm font-semibold text-slate-800">{{ $normalUser->name }}</p><p class="truncate text-xs text-slate-500">{{ $normalUser->email }}</p><p class="mt-1 text-xs font-semibold text-primary-600">{{ $roleLabel }}</p></div>
                        <x-dropdown-link :href="route('user.profile.edit')"><i class="ph ph-user me-2"></i>Meu perfil</x-dropdown-link>
                        <x-dropdown-link :href="route('user.submissions.index')"><i class="ph ph-files me-2"></i>Minhas demandas</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">@csrf<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"><i class="ph ph-sign-out me-2"></i>Sair</x-dropdown-link></form>
                    </x-slot>
                </x-dropdown>
            @elseif ($adminUser)
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger"><button type="button" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-1.5 text-[#142c59] transition hover:bg-blue-50" aria-label="Menu da conta de {{ $adminUser->name }}"><span class="grid h-9 w-9 place-items-center rounded-lg bg-primary-50 font-bold text-primary-600">{{ mb_strtoupper(mb_substr($adminUser->name, 0, 1)) }}</span><i class="ph ph-caret-down hidden text-xs sm:block" aria-hidden="true"></i></button></x-slot>
                    <x-slot name="content"><div class="border-b border-slate-100 px-4 py-3"><p class="truncate text-sm font-semibold">{{ $adminUser->name }}</p><p class="truncate text-xs text-slate-500">{{ $adminUser->email }}</p></div><x-dropdown-link :href="route('admin.dashboard')">Painel administrativo</x-dropdown-link><x-dropdown-link :href="route('admin.profile.edit')">Meu perfil</x-dropdown-link><form method="POST" action="{{ route('logout') }}">@csrf<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Sair</x-dropdown-link></form></x-slot>
                </x-dropdown>
            @else
                <div class="hidden items-center gap-2 xl:flex"><a href="{{ route('login') }}" class="rounded-xl px-3 py-2.5 text-sm font-semibold text-[#142c59] hover:bg-slate-100">Entrar</a><a href="{{ route('register') }}" class="rounded-xl border border-[#142c59] px-3 py-2.5 text-sm font-semibold text-[#142c59] hover:bg-blue-50">Criar conta</a></div>
            @endif

            <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen.toString()" :aria-label="mobileOpen ? 'Fechar menu' : 'Abrir menu'" aria-controls="mobile-navigation" class="grid h-11 w-11 place-items-center rounded-xl border border-slate-200 text-[#142c59] transition hover:bg-slate-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 xl:hidden"><i class="ph text-2xl" :class="mobileOpen ? 'ph-x' : 'ph-list'" aria-hidden="true"></i></button>
        </div>
    </div>

    <nav id="mobile-navigation" x-show="mobileOpen" x-cloak x-transition class="max-h-[calc(100vh-8rem)] overflow-y-auto border-t border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-[#142c59] xl:hidden" aria-label="Navegação para telas menores">
        <div class="mx-auto grid max-w-7xl gap-1 sm:grid-cols-2">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}" @click="mobileOpen = false" @if ($link['active']) aria-current="page" @endif class="flex items-center gap-3 rounded-xl px-4 py-3 {{ $link['active'] ? 'bg-blue-50 text-blue-800' : 'hover:bg-slate-50' }}"><i class="ph {{ $link['icon'] }} text-lg" aria-hidden="true"></i>{{ $link['label'] }}</a>
            @endforeach
            @if (! $adminUser)<a href="{{ $normalUser ? route('user.submissions.create') : route('login', ['redirect' => route('user.submissions.create', absolute: false)]) }}" class="mt-2 flex items-center justify-center gap-2 rounded-xl bg-[#3bd5aa] px-4 py-3 font-bold text-[#142c59] sm:col-span-2"><i class="ph ph-plus-circle text-lg" aria-hidden="true"></i>Nova demanda</a>@endif
            @if (! $normalUser && ! $adminUser)<div class="mt-2 grid grid-cols-2 gap-2 border-t border-slate-200 pt-4 sm:col-span-2"><a href="{{ route('login') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-center">Entrar</a><a href="{{ route('register') }}" class="rounded-xl border border-[#142c59] px-4 py-3 text-center">Criar conta</a></div>@endif
        </div>
    </nav>
</header>
