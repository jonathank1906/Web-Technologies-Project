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

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased">
    @include('layouts.navigation')
    
    <div class="min-h-screen bg-gray-800">
        <!-- Custom Sidebar -->
        <nav class="custom-sidebar" id="sidebar">
            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href="/" class="sidebar-link">
                        <x-monoicon-home class="sidebar-icon" />
                        <span class="sidebar-text">Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('connections') }}" class="sidebar-link">
                        <x-tabler-wifi class="sidebar-icon" />
                        <span class="sidebar-text">Explore</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('messages') }}" class="sidebar-link">
                        <x-tabler-messages class="sidebar-icon" />
                        <span class="sidebar-text">Messages</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link">
                        <x-css-profile class="sidebar-icon" />
                        <span class="sidebar-text">Profile</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Page Heading -->
            @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <!-- Page Content -->
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>