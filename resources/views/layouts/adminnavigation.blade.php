<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 rounded-b-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Mobile Hamburger (Left) -->
            <div class="flex items-center md:hidden">
                <button @click="$dispatch('toggle-sidebar')"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Logo (Center) -->
            <div class="flex items-center justify-center flex-1 md:hidden">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </div>

            <!-- Desktop push right -->
            <div class="hidden md:flex flex-1"></div>

            <!-- Settings Dropdown (Right for Mobile & Desktop) -->
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Show normal name on Desktop, circle on Mobile -->
                        <button class="inline-flex items-center px-2 md:px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            
                            <!-- Desktop view -->
                            <div class="hidden md:flex items-center">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Mobile view: Circle with Initial -->
                            <div class="md:hidden w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                                <span class="text-blue-600 font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>

                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100 md:hidden">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
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
