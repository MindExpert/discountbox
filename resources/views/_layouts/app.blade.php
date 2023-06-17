<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @isset($html_tag_data) @foreach ($html_tag_data as $key=> $value) data-{{$key}}='{{$value}}' @endforeach @endisset>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-layout-style="" data-layout-position="fixed"  data-topbar="light">--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
@include('_commons.hidden-credits')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="title" content="@yield('seo_title', config('app.seo_title'))">
    <meta name="description" content="{{ $description ?? ''}}">
    <meta name="author" content="{{config('app.author')}}">
    <meta name="locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <meta name="base_url" content="{{ url('/') }}">
    <meta name="generator" content="Laravel {{ App::VERSION() }}">
    <link rel="canonical" href="@yield('canonical', request()->url())" />

    <!-- Open Graph Meta -->
    <meta property="og:title" content="PDR - Consulting">
    <meta property="og:site_name" content="PDR-Consulting">
    <meta property="og:description" content="PDR - Consulting - Web App">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- App favicon -->
    @include('_commons.favicon')

    <!-- Stylesheets -->
    @yield('before-styles')
    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Select2 Css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Toast Css -->
    <link href="{{asset('assets/libs/toastr/build/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css" />


    @yield('styles')

    <!-- Used to push from partial elements -->
    @stack('partial-styles')
</head>
<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('_partials.header')
        @include('_partials.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Start content -->
                <div class="{{ $container_class ?? 'container-fluid' }}">
                    {{--@include('_partials.breadcrumbs')--}}
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('_partials.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->
    @include('_partials.logout-modal')
    @include('_partials.action-modal')

    <!-- BACK TO TOP -->
    {{--@include('_partials.back-to-top')--}}

    <!-- JAVASCRIPT -->
    @yield('before-scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
{{--    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>--}}
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tippy/tippy.all.min.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('script')
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('after-scripts')

    @stack('partial-scripts')
    @include('_partials.flash-notifications')
</body>
</html>
