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
