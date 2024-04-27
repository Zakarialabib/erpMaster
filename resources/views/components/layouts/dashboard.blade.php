<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="nofollow">

    <title>@yield('title') || {{ settings('company_name') }}</title>
    <!-- Styles -->

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <meta name="theme-color" content="#000000">
    <link rel="manifest" href="manifest.json" />
    <link rel="apple-touch-icon" href="/images/icon-192x192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ settings('company_name') }}">

    @vite('resources/css/app.css')

    @livewireStyles

    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />

    <!-- Scripts -->
    @vite('resources/js/app.js')
    @livewireScriptConfig

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

    <x-livewire-alert::scripts />

    @stack('scripts')

</head>

<body class="antialiased bg-body text-body font-body" dir="ltr" x-data="mainState"
    :class="{ dark: isDarkMode, rtl: isRtl }">
    
    <x-loading-mask />
    <div @resize.window="handleWindowResize">
        <div class="min-h-screen">

            {{-- <x-sidebar.sidebar /> --}}

            @livewire('utils.sidebar')

            <!-- Page Wrapper -->
            <div class="flex flex-col min-h-screen"
                :class="{
                    'lg:ml-64': isSidebarOpen && !isRtl,
                    'lg:mr-64': isSidebarOpen && isRtl,
                    'lg:ml-16': !isSidebarOpen && !isRtl,
                    'lg:mr-16': !isSidebarOpen && isRtl,
                }"
                style="transition-property: margin; transition-duration: 150ms;">

                <!-- Navigation Bar-->
                <x-navbar />

                <main class="flex-1 px-6 pb-10">

                    @yield('breadcrumb')

                    @yield('content')

                    @isset($slot)
                        {{ $slot }}
                    @endisset

                    <x-settings-bar />

                </main>
            </div>
        </div>
    </div>

</body>

</html>
