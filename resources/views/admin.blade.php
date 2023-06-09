<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css'])
    @stack('styles')
</head>

<body class="{{ auth()->check() ? 'sidebar-mini' : null }} {{ $class ?? null }}">
    @auth
    <div class="wrapper">
        <!-- Navbar Componnent -->
        <x-admin.navbar></x-admin-navbar>

        <!-- Sidebar Componnent -->
        <x-admin.sidebar></x-admin.sidebar>

        <div class="content-wrapper">
            @yield('content')
        </div>
        
        <!-- Footer Componnent -->
        <x-admin.footer></x-admin.footer>
    </div>
    @endauth
    @vite(['resources/js/app.js', 'resources/js/admin.js'])
    <script src="{{ asset('assets/js/adminlte.min.js') }}" defer></script>
    @stack('scripts')
</body>
</html>