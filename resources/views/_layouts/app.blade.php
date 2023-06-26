<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('_commons.hidden-credits')
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="{{ asset('assets/css/media-library-pro.css') }}" rel="stylesheet" type="text/css" />
    <livewire:styles />
    <link href="{{ asset('assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    @yield('after-styles')
    <!-- Used to push from partial elements -->
    @stack('partial-styles')
</head>
{{--<body data-sidebar="dark" data-topbar="dark">--}}
<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('_partials.topbar')
        @include('_partials.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="{{ $container_class ?? 'container-fluid' }}">
                    @include('_partials.breadcrumbs')
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('_partials.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    @include('_partials.logout-modal')
    @include('_partials.action-modal')

    <!-- JAVASCRIPT -->
    @yield('before-scripts')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
    <!-- Select2 JS-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <!-- Toast JS -->
    <script src="{{asset('assets/libs/toastr/toastr.min.js')}}"></script>
    <!-- Tippy JS-->
    <script src="{{ asset('assets/libs/tippy/tippy.all.min.js') }}"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js')}}"></script>
    <script src="{{ asset('assets/js/ajax-main.js') }}"></script>

    <livewire:scripts />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    @yield('scripts')

    @yield('after-scripts')

    @stack('partial-scripts')
    @include('_partials.flash-notifications')
</body>
</html>
