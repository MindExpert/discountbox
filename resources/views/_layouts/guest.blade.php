<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Landing | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

<!-- Begin page -->
<div class="layout-wrapper landing">
    @include('_partials.frontend.navigation')

    @yield('content')

    <!-- start footer -->
    @include('_partials.frontend.footer')
    <!--start back-to-top-->
    {{--@include('_partials.frontend.back-to-top')--}}
    <!--end back-to-top-->
</div>
<!-- END wrapper -->
@include('_partials.logout-modal')
@include('_partials.action-modal')


<!-- JAVASCRIPT -->
@yield('before-scripts')
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/pages/landing.init.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@yield('script')
{{--    <script src="{{ asset('js/ajax-form.js') }}"></script>--}}
@yield('after-scripts')

@stack('partial-scripts')
@include('_partials.flash-notifications')
</body>

</html>
