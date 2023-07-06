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
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>
<body>

@include('_partials.frontend.navigation')

@includeWhen((isset($hasHero) && $hasHero == true), '_partials.frontend.hero-section')
<!-- Begin page -->
<main id="main">
    @includeWhen((isset($hasBreadcrumb) && $hasBreadcrumb == true), '_partials.frontend.breadcrumb')

    @yield('content')
</main>
@include('_partials.frontend.preloader')
@include('_partials.frontend.footer')

@include('_partials.frontend.back-to-top')
<!-- END wrapper -->
@include('_partials.logout-modal')
@include('_partials.action-modal')

<!-- JAVASCRIPT -->
@yield('before-scripts')
<!-- Vendor JS Files -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
<!-- Select2 JS-->
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<!-- Toast JS -->
<script src="{{asset('assets/libs/toastr/toastr.min.js')}}"></script>
<!-- Tippy JS-->
<script src="{{ asset('assets/libs/tippy/tippy.all.min.js') }}"></script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Template Main JS File -->
<script src="{{ asset('/frontend/assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/ajax-main.js') }}"></script>
@yield('script')
@yield('after-scripts')

@stack('partial-scripts')
@include('_partials.flash-notifications')
</body>

</html>
