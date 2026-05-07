<div
    x-data="{
        open: window.innerWidth >= 1024,
        collapsed: JSON.parse(localStorage.getItem('uniforma.sidebarCollapsed') ?? 'false'),
        persistCollapsed() {
            localStorage.setItem('uniforma.sidebarCollapsed', JSON.stringify(this.collapsed));
            window.dispatchEvent(new CustomEvent('sidebar-toggled', { detail: { collapsed: this.collapsed } }));
        },
        toggleCollapsed() {
            this.collapsed = !this.collapsed;
            this.persistCollapsed();
        }
    }"
    x-init="window.dispatchEvent(new CustomEvent('sidebar-toggled', { detail: { collapsed: collapsed } }))"
    @resize.window="if (window.innerWidth >= 1024) { open = true; } else { collapsed = false; persistCollapsed(); }"
    @toggle-sidebar.window="open = !open"
    class="relative"
>
    <!-- Overlay para mobile -->
    <div
        x-show="open && window.innerWidth < 1024"
        @click="open = false"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/70 z-40 lg:hidden"
        style="display: none;"
    ></div>

    <!-- Sidebar -->
    <aside
        :class="{
            'translate-x-0': open,
            '-translate-x-full lg:translate-x-0': !open,
            'w-72': !collapsed || window.innerWidth < 1024,
            'lg:w-20': collapsed && window.innerWidth >= 1024
        }"
        class="fixed top-0 left-0 h-full bg-white dark:bg-surface-800 rounded-r-2xl border border-white/5 transition-all duration-300 ease-in-out z-50 overflow-y-auto shrink-0"
    >
        <div class="flex flex-col h-full">
            <!-- Header com botão de toggle -->
            <div
                class="flex items-center p-3 h-14"
                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : 'justify-between'"
            >
                <!-- Logo e título quando expandido -->
                <div
                    x-show="!collapsed || window.innerWidth < 1024"
                    x-transition:enter="transition ease-in-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="flex items-center space-x-3"
                >
                    <x-application-logo class="block h-8 w-8 fill-current text-gray-800 dark:text-white" />
                    <p class="font-sans antialiased text-base text-gray-800 dark:text-white font-semibold tracking-wide">
                        UniForma
                    </p>
                </div>

                <!-- Logo centralizada quando colapsado -->
                <div
                    x-show="collapsed && window.innerWidth >= 1024"
                    x-transition:enter="transition ease-in-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="flex items-center justify-center cursor-pointer"
                    @click="toggleCollapsed()"
                >
                    <x-application-logo class="block h-8 w-8 fill-current text-gray-800 dark:text-white" />
                </div>

                <!-- Toggle button desktop -->
                <button
                    x-show="!collapsed || window.innerWidth < 1024"
                    @click="toggleCollapsed()"
                    class="hidden lg:block p-2 rounded-md dark:text-gray-300 text-gray-800 hover:bg-white/10 dark:hover:text-white transition-colors"
                >
                    <svg x-show="!collapsed" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="collapsed" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Close button mobile -->
                <button @click="open = false" class="lg:hidden p-2 rounded-md text-gray-300 hover:bg-white/10 hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <x-divider class="mx-3 -translate-y-2" />

            <!-- Menu items -->
            <div class="flex-1 p-3">
                <ul class="flex flex-col gap-0.5">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                            class="flex items-start py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-400/20 text-primary-400 font-medium' : 'text-gray-800 dark:text-gray-300 hover:text-primary-400 hover:bg-primary-400/20' }} group"
                        >
                            <span class="grid place-items-center shrink-0"
                                :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                <i class="ph ph-house text-xl"></i>
                            </span>
                            <span x-show="!collapsed || window.innerWidth < 1024"
                                x-transition:enter="transition ease-in-out duration-200"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                class="flex-1">Dashboard</span>
                        </a>
                    </li>

                    @can(['view_permissions', 'view_roles'])
                        <small x-show="!collapsed || window.innerWidth < 1024"
                            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            class="text-xs font-medium text-gray-400">PERMISSÕES</small>
                        <x-divider class="-translate-y-2" />
                    @endcan

                    @can('view_roles')
                        <!-- Roles -->
                        <li>
                            <a href="{{ route('roles.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-start py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-primary-400/20 text-primary-400 font-medium' : 'text-gray-800 dark:text-gray-300 hover:text-primary-400 hover:bg-primary-400/20' }} group"
                            >
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-shield-checkered text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Perfis</span>
                            </a>
                        </li>
                    @endcan

                    @can('view_permissions')
                        <!-- Permissions -->
                        <li>
                            <a href="{{ route('permissions.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-start py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('permissions.*') ? 'bg-primary-400/20 text-primary-400 font-medium' : 'text-gray-800 dark:text-gray-300 hover:text-primary-400 hover:bg-primary-400/20' }} group"
                            >
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-shield-check text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Permissões</span>
                            </a>
                        </li>
                    @endcan

                    @can(['view_logs', 'view_admins'])
                        <small x-show="!collapsed || window.innerWidth < 1024"
                            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" class="text-xs font-medium text-gray-400">SISTEMA</small>
                        <x-divider class="-translate-y-2" />
                    @endcan

                    @can('view_admins')
                        <!-- Admins -->
                        <li>
                            <a href="{{ route('admins.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('admins.*') ? 'bg-primary-400/20 text-primary-400 font-medium' : 'text-gray-800 dark:text-gray-300 hover:text-primary-400 hover:bg-primary-400/20' }} group"
                            >
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-users text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Administradores</span>
                            </a>
                        </li>
                    @endcan

                    @can('view_logs')
                        <!-- Logs -->
                        <li>
                            <a href="{{ route('logs.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-start py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('logs.*') ? 'bg-primary-400/20 text-primary-400 font-medium' : 'text-gray-800 dark:text-gray-300 hover:text-primary-400 hover:bg-primary-400/20' }} group"
                            >
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-clock-counter-clockwise text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Logs</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </aside>

    <!-- Botão para abrir sidebar no mobile -->
    <button
        @click="open = true"
        x-show="!open"
        class="fixed bottom-4 left-4 lg:hidden z-30 rounded-full bg-surface-800 p-3 text-white shadow-lg shadow-black/30 transition-colors hover:bg-white/10"
        style="display: none;"
    >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>
