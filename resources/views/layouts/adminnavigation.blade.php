<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white text-slate-800 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Mobile Hamburger (Left) -->
            <div class="flex items-center md:hidden">
                <button @click="$dispatch('toggle-sidebar')"
                    class="inline-flex items-center justify-center rounded-md p-2 text-slate-700 transition hover:bg-slate-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Logo (Center) -->
            <div class="flex flex-1 items-center justify-center md:hidden">
                <x-application-logo class="block h-9 w-auto fill-current text-[#142c59]" />
            </div>

            <!-- Desktop push right -->
            <div class="hidden flex-1 md:flex"></div>

            <!-- Settings Dropdown (Right for Mobile & Desktop) -->
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Show normal name on Desktop, circle on Mobile -->
                        <button class="inline-flex items-center rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium leading-4 text-slate-700 transition hover:bg-slate-50 focus:outline-none md:px-3">
                            <!-- Desktop view -->
                            <div class="hidden items-center md:flex">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Mobile view: Circle with Initial -->
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 md:hidden">
                                <span class="text-sm font-bold text-gray-800 ">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="border-b border-gray-200 px-4 py-2 md:hidden">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <x-dropdown-link :href="route('admin.profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
