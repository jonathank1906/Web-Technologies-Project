<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" ... />

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
    <div class="min-h-screen bg-gray-800">
        <!-- Custom Sidebar -->
        <nav class="custom-sidebar" id="sidebar">
            <ul class="sidebar-menu flex flex-col h-full">
                <li class="sidebar-item">
                    <a href="/" class="sidebar-link flex items-center hover:bg-base-300">
                        <x-monoicon-home class="sidebar-icon" />
                        <span class="sidebar-text">Home</span>
                    </a>
                </li>
                <li class="sidebar-item hover:bg-base-300">
                    <a href="{{ route('connections') }}" class="sidebar-link">
                        <x-tabler-wifi class="sidebar-icon" />
                        <span class="sidebar-text">Connections</span>
                    </a>
                </li>
                <li class="sidebar-item hover:bg-base-300">
                    <a href="{{ route('messages') }}" class="sidebar-link">
                        <x-tabler-messages class="sidebar-icon" />
                        <span class="sidebar-text">Messages</span>
                    </a>
                </li>
                <li class="sidebar-item hover:bg-base-300">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link">
                        <x-css-profile class="sidebar-icon" />
                        <span class="sidebar-text">Settings</span>
                    </a>
                </li>
                <x-more-nav />
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content bg-base-100" id="mainContent">
            <!-- Page Heading -->
            @isset($header)
            <header class="bg-base-200 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <!-- Page Content -->
            {{ $slot }}
        </main>
    </div>
    
    <script>
    (function() {
        const root = document.documentElement;
        const saved = localStorage.getItem('theme');            // 'light' | 'dark'
        const theme = saved ?? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        root.setAttribute('data-theme', theme);
        // Sync labels early
        document.querySelectorAll('.theme-toggle').forEach(btn => {
            const isDark = theme === 'dark';
            btn.querySelector('.light-label')?.classList.toggle('hidden', isDark);
            btn.querySelector('.dark-label')?.classList.toggle('hidden', !isDark);
        });
    })();
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.documentElement;
        const buttons = document.querySelectorAll('.theme-toggle');
        const updateLabels = () => {
            const isDark = (root.getAttribute('data-theme') === 'dark');
            buttons.forEach(btn => {
                btn.querySelector('.light-label')?.classList.toggle('hidden', isDark);
                btn.querySelector('.dark-label')?.classList.toggle('hidden', !isDark);
            });
        };
        buttons.forEach(btn => btn.addEventListener('click', () => {
            const current = root.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateLabels();
        }));
        updateLabels();
    });
    </script>
    @livewireScripts
</body>

<nav class="custom-sidebar bg-base-200 text-base-content" id="sidebar">
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="/" class="sidebar-link flex items-center hover:bg-base-300 rounded-md px-3 py-2">
                <x-monoicon-home class="sidebar-icon" />
                <span class="sidebar-text">Home</span>
            </a>
        </li>
        <!-- repeat for other links -->
    </ul>
</nav>

</html>