<!-- ======= Header V1 ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            {{--<h1><a href="{{ url('/') }}">{{ config('app.name') }}</a></h1>--}}
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="{{ url('/') }}"><img src="{{ asset('/frontend/assets/img/logox1.png') }}" alt="" class="img-fluid"></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link {{ active_route('frontend.homepage') }}" href="{{ url('/') }}">Home</a></li>
                <li><a class="nav-link {{ active_route('frontend.discount-boxes.index-by-status', 'active', \App\Enums\StatusEnum::IN_PROGRESS->value) }}" href="{{ route('frontend.discount-boxes.index-by-status', ['status' => \App\Enums\StatusEnum::IN_PROGRESS->value]) }}">ScontaBOX in Corso</a></li>
                <li><a class="nav-link {{ active_route('frontend.discount-boxes.index-by-status', 'active', \App\Enums\StatusEnum::CONCLUDED->value) }}" href="{{ route('frontend.discount-boxes.index-by-status', ['status' => \App\Enums\StatusEnum::CONCLUDED->value]) }}">ScontaBOX Conclusi</a></li>
                <li><a class="nav-link {{ active_route('frontend.partners') }}" href="{{ route('frontend.partners') }}">Partners</a></li>
                <li><a class="nav-link {{ active_route('frontend.how-it-works') }}" href="{{ route('frontend.how-it-works') }}">Come Funziona</a></li>
                <li><a class="nav-link {{ active_route('frontend.testimonials') }}" href="{{ route('frontend.testimonials') }}">Testimonianze</a></li>
                {{--<li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>--}}
                {{--    <ul>--}}
                {{--        <li><a href="#">Drop Down 1</a></li>--}}
                {{--        <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>--}}
                {{--            <ul>--}}
                {{--                <li><a href="#">Deep Drop Down 1</a></li>--}}
                {{--                <li><a href="#">Deep Drop Down 2</a></li>--}}
                {{--                <li><a href="#">Deep Drop Down 3</a></li>--}}
                {{--                <li><a href="#">Deep Drop Down 4</a></li>--}}
                {{--                <li><a href="#">Deep Drop Down 5</a></li>--}}
                {{--            </ul>--}}
                {{--        </li>--}}
                {{--        <li><a href="#">Drop Down 2</a></li>--}}
                {{--        <li><a href="#">Drop Down 3</a></li>--}}
                {{--        <li><a href="#">Drop Down 4</a></li>--}}
                {{--    </ul>--}}
                {{--</li>--}}
                @if (Route::has('login'))
                    @auth
                        <li>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#partial-logout-modal">Logout</a>
                        </li>
                        @if(auth()->user()->role === \App\Enums\RolesEnum::ADMIN)
                            <li><a href="{{ route('management.dashboard') }}" class="nav-link">Dashboard</a></li>
                        @else
                            <li><a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="signup">Log in</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="getstarted">Register</a></li>
                        @endif
                    @endauth
               @endif
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->



{{--<!-- ======= Header v2 ======= -->--}}
{{--<header id="header" class="fixed-top header-inner-pages">--}}
{{--    <div class="container d-flex align-items-center">--}}
{{--        --}}{{--<h1 class="logo me-auto"><a href="index.html">{{ config('app.name') }}</a></h1>--}}
{{--        <!-- Uncomment below if you prefer to use an image logo -->--}}
{{--        <a href="{{ url('/') }}" class="logo me-auto"><img src="{{ asset('/frontend/assets/img/logox1.png') }}" alt="" class="img-fluid"></a>--}}
{{--        <nav id="navbar" class="navbar">--}}
{{--            <ul>--}}
{{--                <li><a class="nav-link active" href="{{ url('/') }}">Home</a></li>--}}
{{--                <li><a class="nav-link" href="#features">ScontaBOX in Corso</a></li>--}}
{{--                <li><a class="nav-link" href="#gallery">ScontaBOX Conclusi</a></li>--}}
{{--                <li><a class="nav-link" href="#pricing">Come Funziona</a></li>--}}
{{--                <li><a class="nav-link" href="#faq">Testimonianze</a></li>--}}
{{--                --}}{{--<li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>--}}
{{--                --}}{{--    <ul>--}}
{{--                --}}{{--        <li><a href="#">Drop Down 1</a></li>--}}
{{--                --}}{{--        <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>--}}
{{--                --}}{{--            <ul>--}}
{{--                --}}{{--                <li><a href="#">Deep Drop Down 1</a></li>--}}
{{--                --}}{{--                <li><a href="#">Deep Drop Down 2</a></li>--}}
{{--                --}}{{--                <li><a href="#">Deep Drop Down 3</a></li>--}}
{{--                --}}{{--                <li><a href="#">Deep Drop Down 4</a></li>--}}
{{--                --}}{{--                <li><a href="#">Deep Drop Down 5</a></li>--}}
{{--                --}}{{--            </ul>--}}
{{--                --}}{{--        </li>--}}
{{--                --}}{{--        <li><a href="#">Drop Down 2</a></li>--}}
{{--                --}}{{--        <li><a href="#">Drop Down 3</a></li>--}}
{{--                --}}{{--        <li><a href="#">Drop Down 4</a></li>--}}
{{--                --}}{{--    </ul>--}}
{{--                --}}{{--</li>--}}
{{--                @if (Route::has('login'))--}}
{{--                    @auth--}}
{{--                        <li>--}}
{{--                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#partial-logout-modal">Logout</a>--}}
{{--                        </li>--}}
{{--                        @if(auth()->user()->role === \App\Enums\RolesEnum::ADMIN)--}}
{{--                            <li><a href="{{ route('management.dashboard') }}" class="nav-link">Dashboard</a></li>--}}
{{--                        @else--}}
{{--                            <li><a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a></li>--}}
{{--                        @endif--}}
{{--                    @else--}}
{{--                        <li><a href="{{ route('login') }}" class="getstarted">Log in</a></li>--}}
{{--                        @if (Route::has('register'))--}}
{{--                            <li><a href="{{ route('register') }}" class="getstarted">Register</a></li>--}}
{{--                        @endif--}}
{{--                    @endauth--}}
{{--                @endif--}}
{{--            </ul>--}}
{{--            <i class="bi bi-list mobile-nav-toggle"></i>--}}
{{--        </nav><!-- .navbar -->--}}
{{--    </div>--}}
{{--</header><!-- End Header -->--}}
