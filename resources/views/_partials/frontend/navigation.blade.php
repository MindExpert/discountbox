<nav class="navbar navbar-expand-lg navbar-landing fixed-top is-sticky">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo_asta_dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="17">
            <img src="{{ asset('assets/images/logo_asta_light.png') }}" class="card-logo card-logo-light" alt="logo light" height="17">
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                <li class="nav-item">
                    <a class="nav-link fs-14 active" href="#hero">Home</a>
                </li>
            </ul>

            @if (Route::has('login'))
                <div class="">
                    @auth
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#partial-logout-modal">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Logout</span>
                        </a>
                        @if(auth()->user()->role === \App\Enums\RolesEnum::ADMIN)
                            <a href="{{ route('management.dashboard') }}" class="btn btn-link fw-medium text-decoration-none text-dark">Dashboard</a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="btn btn-link fw-medium text-decoration-none text-dark">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>
<!-- end navbar -->
