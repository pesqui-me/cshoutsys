<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="msapplication-config" content="browserconfig.xml">
        <meta name="description" content="Index page">
        <meta name="keywords" content="index, page">
        <meta name="author" content="">

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
        
        <link href="{{ asset('assets/admin/css/admin.css') }}" rel="stylesheet">

        <title>CASH OUT - Investissement Intelligent & Rentable</title>
    </head>
    <body>
        {{-- @include('layouts.guest.partials.preloader') --}}
        @include('layouts.admin.partials.back-side')

        <main class="main mt-3">
            {{ $slot }}
        </main>

        @include('layouts.guest.partials.main-footer')

        <script src="{{ asset('assets/guest/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
    </body>
</html>