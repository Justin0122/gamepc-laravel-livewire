<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <style>
            body {
                background: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' fill=\'%23e2e8f0\'%3E%3Ccircle cx=\'5\' cy=\'5\' r=\'2\'/%3E%3Ccircle cx=\'5\' cy=\'15\' r=\'2\'/%3E%3Ccircle cx=\'15\' cy=\'5\' r=\'2\'/%3E%3Ccircle cx=\'15\' cy=\'15\' r=\'2\'/%3E%3C/svg%3E');
            }

        </style>
    </head>
    <body class="font-sans antialiased">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
        <x-banner />

        <div class="min-h-screen bg-gradient-radial dark:from-gray-700 dark:to-gray-900 dark:text-gray-100 from-teal-50 to-gray-100 text-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>


        @stack('modals')

        @livewireScripts
    </body>
</html>
