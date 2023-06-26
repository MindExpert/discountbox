<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }} | {{ config('app.name') }}</title>

    @include('_partials.meta')
    <!-- App favicon -->
    @include('_commons.favicon')

    <!-- Stylesheets -->
    @yield('before-styles')
    <!-- Bootstrap Css -->
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    @yield('styles')
    <!-- Select2 Css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Toast Css -->
    <link href="{{asset('assets/libs/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @yield('after-styles')
    <!-- Used to push from partial elements -->
    @stack('partial-styles')
</head>
<body class="@yield('body-class')">
    @yield('content')

    <!-- JAVASCRIPT -->
    @yield('before-scripts')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('assets/libs/tippy/tippy.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @yield('scripts')
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js')}}"></script>
    <script src="{{ asset('assets/js/ajax-main.js') }}"></script>
    @yield('after-scripts')

    @stack('partial-scripts')
    @include('_partials.flash-notifications')
</body>
</html>
