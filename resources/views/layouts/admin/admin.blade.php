<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="PRIME BLOCK - Admin Dashboard">
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="google" content="notranslate">
    <meta name="google-site-verification" content="google-site-verification=google-site-verification">
    <meta name="google-site-verification" content="google-site-verification">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <title>{{ $title ?? 'Dashboard' }} - PRIME BLOCK Admin</title>
    
    @stack('styles')
</head>
    <body class="bg-gray-50 dark:bg-gray-900 font-inter antialiased" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar -->
        @include('layouts.admin.partials.sidebar')
        
        <!-- Sidebar Overlay (Mobile) -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
            style="display: none;"
        ></div>
        
        <!-- Main Content -->
        <div class="lg:ml-72 min-h-screen transition-all duration-300">
            
            <!-- Header -->
            @include('layouts.admin.partials.header')
            
            <!-- Page Content -->
            <main class="p-4 lg:p-8">
                {{ $slot }}
            </main>
            
            <!-- Footer -->
            @include('layouts.admin.partials.footer')
            
        </div>
        
        <!-- Scripts -->
        <script>
            // Dark mode toggle
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
            
            // Auto-hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('[data-auto-dismiss]');
                alerts.forEach(alert => {
                    alert.style.transition = 'all 0.3s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 5000);
        </script>
        
        @stack('scripts')
    </body>
</html>