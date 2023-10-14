@extends('_layouts.auth', [
    'title' => __('auth.verify_email.title'),
])

@section('content')
    <div class="account-pages my-4 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-header">{{ __('auth.verify_email.title') }}</div>

                        <div class="card-body p-lg-5 p-4">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('auth.verify_email.msg_1') }}
                                </div>
                            @endif

                            {{ __('auth.verify_email.msg_2') }}
                            {{ __('auth.verify_email.msg_3') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                    {{ __('auth.verify_email.request_another') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
