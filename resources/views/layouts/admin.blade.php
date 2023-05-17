<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased">

    <livewire:components.modal-component/>
    
    <div class="min-h-screen bg-gray-100">
        {{-- @include('layouts.navigation') --}}

        <div class="flex-col w-full md:flex md:flex-row md:min-h-screen">
            @include('layouts.admin-navigation')
            <!-- Page Content -->
            <div class="w-full">
                @yield('content')
            </div>
        </div>


    </div>
    @livewireScripts
</body>

</html>