<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/regular/style.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarCollapsed: false }" @sidebar-toggled.window="sidebarCollapsed = $event.detail.collapsed"
        class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        <x-sidebar />

        <div class="flex-1 overflow-y-auto transition-all duration-300 md:px-4"
            :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-[280px]'">
            @include('layouts.adminnavigation')

            <!-- Page Content -->
            <main class="overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @if (session('status'))
        <x-toast type="success" :message="session('status')" />
    @endif

    @if (session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif
</body>

</html>
