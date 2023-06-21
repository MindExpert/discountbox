@extends('_layouts.auth', [
    'title' => __('Reset Password'),
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
                                    <h6 class="card-title text-primary mb-0">{{ __('Reset Password') }}</h6>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                                        <li class="list-inline-item">
                                            <a href="{{ url()->previous() }}" class="align-middle fs-12">
                                                <i class="mdi mdi-backburger align-middle"></i> Back
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="email"
                                           class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Send Password Reset Link') }}
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
