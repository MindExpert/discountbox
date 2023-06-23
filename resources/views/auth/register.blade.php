@extends('_layouts.auth', [
    'title' => __('Register'),
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
                                    <h6 class="card-title text-primary mb-0">{{ __('Register') }}</h6>
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
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <!-- NICKNAME -->
                                    <div class="mb-3">
                                        <label for="nickname" class="form-label">@lang('user.fields.nickname')</label>
                                        <input id="nickname" type="text"
                                               class="form-control @error('nickname') is-invalid @enderror"
                                               name="nickname"
                                               value="{{ old('nickname') }}"
                                               placeholder="@lang('user.fields.nickname')"
                                        />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- FIRST_NAME -->
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">@lang('user.fields.first_name')</label>
                                        <input id="first_name" type="text"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               name="first_name"
                                               value="{{ old('first_name') }}"
                                               placeholder="@lang('user.fields.first_name')"
                                        />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- LAST_NAME -->
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">@lang('user.fields.last_name')</label>
                                        <input id="last_name" type="text"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               name="last_name"
                                               value="{{ old('last_name') }}"
                                               placeholder="@lang('user.fields.last_name')"
                                        />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- MOBILE -->
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label">@lang('user.fields.mobile')</label>
                                        <input id="mobile" type="tel"
                                               class="form-control @error('mobile') is-invalid @enderror"
                                               name="mobile"
                                               value="{{ old('mobile') }}"
                                               placeholder="@lang('user.fields.mobile')"
                                        />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- BIRTH_DATE -->
                                    <div class="mb-3">
                                        <label for="birth_date" class="form-label">@lang('user.fields.birth_date')</label>
                                        <input id="birth_date" type="date"
                                               class="form-control date @error('birth_date') is-invalid @enderror"
                                               name="birth_date"
                                               value="{{ old('birth_date') }}"
                                               placeholder="@lang('user.fields.birth_date')"
                                        />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- EMAIL -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">@lang('user.fields.email')</label>
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}"
                                               autocomplete="email"
                                               placeholder="@lang('user.fields.email')"
                                               required
                                               autofocus
                                        />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- PASSWORD -->
                                    <div class="mb-3">
                                        <label class="form-label" for="password">{{ __('Password') }}</label>
                                        <input id="password"
                                               type="password"
                                               name="password"
                                               class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                               autocomplete="new-password"
                                               placeholder="@lang('Enter your password')"
                                               required
                                        />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- PASSWORD CONFIRM -->
                                    <div class="mb-3">
                                        <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm"
                                               type="password"
                                               class="form-control pe-5 password-input"
                                               name="password_confirmation"
                                               autocomplete="new-password"
                                               placeholder="@lang('Confirm your password')"
                                               required
                                        />
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">{{ __('Register') }}</button>
                                    </div>
                                </form>

                                <div class="mt-4 text-center">
                                    <h5 class="font-size-14 mb-3">Sign up using</h5>

                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="#"
                                               class="social-list-item bg-primary text-white border-primary">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"
                                               class="social-list-item bg-info text-white border-info">
                                                <i class="mdi mdi-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"
                                               class="social-list-item bg-danger text-white border-danger">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-5 text-center">
                                <p class="mb-0">Already Have an account? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Sign In</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
