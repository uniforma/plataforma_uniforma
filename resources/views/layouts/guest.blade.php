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

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Lado da imagem: escondida em telas pequenas -->
        <div class="hidden md:block md:w-1/2 min-h-screen">
            <!-- Substitua o src pela sua imagem quando estiver pronta -->
            <img src="{{ asset('images/arts/auth_image.png') }}" alt="Imagem lateral" class="object-cover w-full h-full" />
        </div>

        <!-- Lado do formulário -->
        <div class="w-full h-screen md:w-1/2 flex items-center justify-center bg-linear-to-r from-[#E9D8DF] to-[#DDDBF1] dark:from-[#674DF0] dark:to-[#0E2A46]">
            <div class="w-full max-w-md px-6 py-8">
                <div class="flex justify-center mb-6">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>

                <div class="bg-white dark:bg-[#333931] shadow-md overflow-hidden rounded-lg">
                    <div class="p-6 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
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
