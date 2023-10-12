@extends('_layouts.auth', [
    'title' => 'Login',
])

@section('content')
    <div class="account-pages my-4 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title text-primary mb-0">{{ __('Login') }}</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                                        <li class="list-inline-item">
                                            <a href="{{ url('/') }}" class="align-middle">
                                                <i class="mdi mdi-home align-middle"></i> @lang('sidebar.menu.home')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-lg-5 p-4">
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
                                </form>

                                {{--<div class="mt-4 text-center">--}}
                                {{--    <h5 class="font-size-14 mb-3">Sign in with</h5>--}}
                                {{--    <ul class="list-inline">--}}
                                {{--        <li class="list-inline-item">--}}
                                {{--            <a href="#"--}}
                                {{--               class="social-list-item bg-primary text-white border-primary">--}}
                                {{--                <i class="mdi mdi-facebook"></i>--}}
                                {{--            </a>--}}
                                {{--        </li>--}}
                                {{--        <li class="list-inline-item">--}}
                                {{--            <a href="#" class="social-list-item bg-info text-white border-info">--}}
                                {{--                <i class="mdi mdi-twitter"></i>--}}
                                {{--            </a>--}}
                                {{--        </li>--}}
                                {{--        <li class="list-inline-item">--}}
                                {{--            <a href="#" class="social-list-item bg-danger text-white border-danger">--}}
                                {{--                <i class="mdi mdi-google"></i>--}}
                                {{--            </a>--}}
                                {{--        </li>--}}
                                {{--    </ul>--}}
                                {{--</div>--}}
                            </div>

                            <div class="mt-4 text-center">
                                <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->
@endsection
