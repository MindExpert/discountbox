@extends('_layouts.app', [
    'title' => __('Confirm Password'),
])

@section('content')
    <div class="account-pages my-4 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-header">{{ __('auth.confirm_password') }}</div>

                        <div class="card-body p-lg-5 p-4">
                            {{ __('auth.login.confirm_before') }}

                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('auth.login.password') }}</label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           autocomplete="current-password"
                                           placeholder="@lang('auth.login.password_label')"
                                           required
                                    />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('auth.confirm_password') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('auth.forgot_password.title') }}
                                            </a>
                                        @endif
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
