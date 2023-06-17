@extends('_layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-primary mb-0">{{ __('Login') }}</h6>
                            </div>
                            <div class="flex-shrink-0">
                                <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{ url('/') }}" class="align-middle">
                                            <i class="mdi mdi-home align-middle"></i> Home
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="p-lg-5 p-4">
                        <div class="mt-0">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autocomplete="email"
                                           placeholder="@lang('Enter your email address')"
                                           autofocus
                                    />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    @if (Route::has('password.request'))
                                        <div class="float-end">
                                            <a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot Your Password?') }}</a>
                                        </div>
                                    @endif
                                    <label class="form-label" for="password">{{ __('Password') }}</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input id="password" type="password"
                                               name="password"
                                               placeholder="@lang('Enter your password')"
                                               class="form-control @error('password') is-invalid @enderror"
                                               autocomplete="current-password"
                                               required
                                        />
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="auth-remember-check" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="auth-remember-check">{{ __('Remember Me') }}</label>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                                </div>

                                {{--<div class="mt-4 text-center">--}}
                                {{--    <div class="signin-other-title">--}}
                                {{--        <h5 class="fs-13 mb-4 title">Sign In with</h5>--}}
                                {{--    </div>--}}
                                {{--    <div>--}}
                                {{--        <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>--}}
                                {{--        <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>--}}
                                {{--        <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>--}}
                                {{--        <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>--}}
                                {{--    </div>--}}
                                {{--</div>--}}

                            </form>
                        </div>

                        <div class="mt-5 text-center">
                            <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="col-lg-12">--}}
{{--        <div class="card overflow-hidden">--}}
{{--            <div class="row g-0">--}}
{{--                <div class="col-lg-6">--}}
{{--                    <div class="p-lg-5 p-4 auth-one-bg h-100">--}}
{{--                        <div class="bg-overlay"></div>--}}
{{--                        <div class="position-relative h-100 d-flex flex-column">--}}
{{--                            <div class="mb-4">--}}
{{--                                <a href="{{ url('/') }}" class="d-block">--}}
{{--                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="18">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="mt-auto">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <i class="ri-double-quotes-l display-4 text-success"></i>--}}
{{--                                </div>--}}

{{--                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">--}}
{{--                                    <div class="carousel-indicators">--}}
{{--                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>--}}
{{--                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>--}}
{{--                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>--}}
{{--                                    </div>--}}
{{--                                    <div class="carousel-inner text-center text-white pb-5">--}}
{{--                                        <div class="carousel-item active">--}}
{{--                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="carousel-item">--}}
{{--                                            <p class="fs-15 fst-italic">" The theme is really great with an amazing customer support."</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="carousel-item">--}}
{{--                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- end carousel -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- end col -->--}}

{{--                <div class="col-lg-6">--}}
{{--                    <div class="p-lg-5 p-4">--}}
{{--                        <div>--}}
{{--                            <h5 class="text-primary">{{ __('Login') }}</h5>--}}
{{--                        </div>--}}

{{--                        <div class="mt-4">--}}
{{--                            <form method="POST" action="{{ route('login') }}">--}}
{{--                                @csrf--}}

{{--                                <div class="mb-3">--}}
{{--                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>--}}
{{--                                    <input id="email" type="email"--}}
{{--                                           class="form-control @error('email') is-invalid @enderror" name="email"--}}
{{--                                           value="{{ old('email') }}" required autocomplete="email" autofocus>--}}
{{--                                    @error('email')--}}
{{--                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="mb-3">--}}
{{--                                    @if (Route::has('password.request'))--}}
{{--                                        <div class="float-end">--}}
{{--                                            <a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot Your Password?') }}</a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    <label class="form-label" for="password-input">{{ __('Password') }}</label>--}}
{{--                                    <div class="position-relative auth-pass-inputgroup mb-3">--}}
{{--                                        <input id="password-input" type="password"--}}
{{--                                               name="password"--}}
{{--                                               placeholder="Enter password"--}}
{{--                                               class="form-control pe-5 password-input @error('password') is-invalid @enderror"--}}
{{--                                               required autocomplete="current-password">--}}
{{--                                        --}}{{--<button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>--}}
{{--                                    </div>--}}
{{--                                    @error('password')--}}
{{--                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember"--}}
{{--                                           id="auth-remember-check" {{ old('remember') ? 'checked' : '' }}>--}}
{{--                                    <label class="form-check-label" for="auth-remember-check">{{ __('Remember Me') }}</label>--}}
{{--                                </div>--}}

{{--                                <div class="mt-4">--}}
{{--                                    <button class="btn btn-success w-100" type="submit">Sign In</button>--}}
{{--                                </div>--}}

{{--                                <div class="mt-4 text-center">--}}
{{--                                    <div class="signin-other-title">--}}
{{--                                        <h5 class="fs-13 mb-4 title">Sign In with</h5>--}}
{{--                                    </div>--}}

{{--                                    <div>--}}
{{--                                        <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>--}}
{{--                                        <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>--}}
{{--                                        <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>--}}
{{--                                        <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </form>--}}
{{--                        </div>--}}

{{--                        <div class="mt-5 text-center">--}}
{{--                            <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- end col -->--}}
{{--            </div>--}}
{{--            <!-- end row -->--}}
{{--        </div>--}}
{{--        <!-- end card -->--}}
{{--    </div>--}}
    <!-- end col -->
@endsection
