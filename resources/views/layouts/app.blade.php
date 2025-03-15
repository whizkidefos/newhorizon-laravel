<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'New Horizon Healthcare') }} - @yield('title')</title>

    <!-- Meta tags for SEO -->
    <meta name="description" content="@yield('meta_description', 'Leading healthcare staffing solutions in North Wales and North West England')">
    <meta name="keywords" content="@yield('meta_keywords', 'healthcare staffing, nurses, care assistants, North Wales, North West England')">

    <!-- Favicon -->
    <link rel="icon" href="{{ url('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
    <link rel="mask-icon" href="{{ url('favicon.svg') }}" color="#F59E0B">
    <meta name="theme-color" content="#F59E0B" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#FBBF24" media="(prefers-color-scheme: dark)">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes text-slide {
            0% { transform: translateY(0); }
            20% { transform: translateY(-1.25em); }
            40% { transform: translateY(-2.5em); }
            60% { transform: translateY(-3.75em); }
            80% { transform: translateY(-5em); }
        }
        .animate-text-slide {
            animation: text-slide 10s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Toast Notifications -->
        @if (session('success'))
            <x-toast type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-toast type="error" :message="session('error')" />
        @endif

        @if (session('warning'))
            <x-toast type="warning" :message="session('warning')" />
        @endif

        @if (session('info'))
            <x-toast type="info" :message="session('info')" />
        @endif

        @if (session('status') === 'profile-updated')
            <x-toast type="success" message="Profile updated successfully." />
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>