<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo / Hamburger For Mobile -->
                <div class="shrink-0 flex items-center">
                    <button @click="$dispatch('toggle-sidebar')" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 transition duration-150 ease-in-out mr-2">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <a href="{{ route('dashboard') }}" class="font-bold text-xl tracking-tight text-indigo-600 dark:text-indigo-400">
                        {{ config('app.name', 'Uniforma') }}
                    </a>
                </div>
            </div>

            <!-- Navbar Right Side (Profile Dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Right slot (ex: User Dropdown) -->
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
</nav>