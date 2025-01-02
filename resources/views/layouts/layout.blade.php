<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>DRRS</title>

        <!-- Fonts -->
        <!-- Noto Sans -->
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        <!-- Bootstrap CSS -->
        <link href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.css') }}" rel="stylesheet">

        <!-- custom accordion css -->
        <link rel="stylesheet" href="{{ asset('css/accordion.css') }}">

        <!-- bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50 p-0 d-flex overflow-hidden flex-column" style="height: 100vh;">
        @if( Route::currentRouteName() != 'loginPage')
            <header>
                <x-header/>
            </header>
        @endif

        <div class="d-flex flex-grow-1 overflow-hidden">
            @auth
                <x-sidebar/>
            @endauth
            
            <!-- stage -->
            <div class="w-100 h-100 overflow-auto text-center p-2 bg-light" style="width: 100vh; height: 100vh;">
                @yield('content')
            </div>
        </div>

        @auth
            <footer>
                <x-bottom-nav/>
            </footer>
        @endauth

        <!-- Include Bootstrap JS and dependencies -->

        <!-- JQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- bootstrap cdn -->
        <script src="{{ asset('bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
        @yield('js')
    </body>
</html>
