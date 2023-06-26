<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <h1><a href="{{ url('/') }}">Appland</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#features">App Features</a></li>
                <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>
                <li><a class="nav-link scrollto" href="#pricing">Pricing</a></li>
                <li><a class="nav-link scrollto" href="#faq">F.A.Q</a></li>
                <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#">Drop Down 1</a></li>
                        <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                            <ul>
                                <li><a href="#">Deep Drop Down 1</a></li>
                                <li><a href="#">Deep Drop Down 2</a></li>
                                <li><a href="#">Deep Drop Down 3</a></li>
                                <li><a href="#">Deep Drop Down 4</a></li>
                                <li><a href="#">Deep Drop Down 5</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Drop Down 2</a></li>
                        <li><a href="#">Drop Down 3</a></li>
                        <li><a href="#">Drop Down 4</a></li>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
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
