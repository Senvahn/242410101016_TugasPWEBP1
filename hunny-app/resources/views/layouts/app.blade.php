<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="{{ asset('style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>
    <body class="font-sans antialiased">
        <div class="site-shell">
            @include('layouts.navigation')
            <div class="dash-layout">
                <!-- Page Content -->
                <main class="main-content">
                    @hasSection('header')
                        <div class="topbar">
                            <div class="topbar-left">
                                @yield('header')
                            </div>
                        </div>
                    @endif
                    <div class="page-content @yield('page-content-class')">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <script src="{{ asset('app.js') }}"></script>
    </body>
</html>

