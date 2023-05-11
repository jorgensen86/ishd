<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
</head>

<body class="hold-transition sidebar-mini {{ $class }}">
    <div class="wrapper">
        <!-- Navbar Componnent -->
        @auth
        <x-admin.navbar></x-admin-navbar>

        <!-- Sidebar Componnent -->
        <x-admin.sidebar></x-admin.sidebar>
        @endauth

        <div class="content-wrapper">
            @yield('content')
        </div>
        
        @auth
        <!-- Footer Componnent -->
        <x-admin.footer></x-admin.footer>
        @endauth

    </div>
    @vite(['resources/js/app.js', 'resources/adminlte/adminlte.js', 'resources/js/admin.js'])
    @yield('scripts')
</body>

</html>