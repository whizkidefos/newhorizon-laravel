<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" href="{{ url('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ url('favicon.png') }}">
    
    <title>@yield('title') - New Horizon Healthcare</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="@yield('title') - New Horizon Healthcare">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Fonts and Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
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
        
        @keyframes blob {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body>
    @include('layouts.frontend.navigation')
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.frontend.footer')
</body>
</html>