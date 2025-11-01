<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Other Imports -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" ... />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased overflow-hidden">
    <div class="min-h-screen">
        <!-- Custom Sidebar -->
        <nav class="bg-base-200 border-t sm:border-t-0 sm:border-r border-base-300  z-50" id="sidebar">
            <ul class="sidebar-menu flex flex-col h-full">
                <li class="sidebar-item">
                    <a href="/" class="sidebar-link flex items-center hover:bg-base-300">
                        <x-monoicon-home class="sidebar-icon text-base-content" />
                        <span class="sidebar-text">Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('connections') }}" class="sidebar-link hover:bg-base-300">
                        <x-tabler-wifi class="sidebar-icon text-base-content" />
                        <span class="sidebar-text">Connections</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('messages') }}" class="sidebar-link hover:bg-base-300">
                        <x-tabler-messages class="sidebar-icon text-base-content" />
                        <span class="sidebar-text">Messages</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('swipe') }}" class="sidebar-link">
                        <x-tabler-heart class="sidebar-icon" />
                        <span class="sidebar-text">Swiper</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('profile.show') }}" class="sidebar-link">
                        <x-css-profile class="sidebar-icon" />
                        <span class="sidebar-text">Profile</span>
                    </a>
                </li>
                <x-more-nav />
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="bg-base-100" id="mainContent">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>

</html>