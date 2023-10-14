@extends('_layouts.auth', [
    'title' => __('auth.auth.reset_password.title'),
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
                                    <h6 class="card-title text-primary mb-0">{{ __('auth.reset_password.title') }}</h6>
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
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('auth.reset_password.email') }}</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ $email ?? old('email') }}"
                                           required
                                           autocomplete="email"
                                           placeholder="@lang('auth.login.email_label')"
                                           autofocus
                                    />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('auth.reset_password.password') }}</label>
                                    <input id="password"
                                           type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           placeholder="@lang('auth.login.password_label')"
                                           autocomplete="new-password"
                                           required
                                    />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">{{ __('auth.confirm_password') }}</label>
                                        <input id="password-confirm"
                                               type="password"
                                               class="form-control"
                                               name="password_confirmation"
                                               autocomplete="new-password"
                                               placeholder="@lang('auth.confirm_password')"
                                               required
                                        />
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('auth.reset_password.reset_password_btn') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
