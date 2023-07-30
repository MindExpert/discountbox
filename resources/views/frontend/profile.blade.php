@extends('_layouts.guest', [
    'title'         => __('user.profile'),
    'hasHero'       => false,
    'hasBreadcrumb' => true,
])

@section('breadcrumbs')
    <li><a href="{{ url('/') }}">@lang('sidebar.menu.home')</a></li>
    <li>@lang('user.profile')</li>
@endsection

@section('content')
    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-title">
                <h2>@lang('user.profile')</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.</p>
            </div>

            <div class="row">
                <div class="col-lg-5 mt-2 order-2 order-lg-1">
                    <ul class="nav nav-tabs flex-column">
                        <!-- PROFILE -->
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" href="#profile-tab">
                                <h4>@lang('user.actions.edit_profile')</h4>
                            </a>
                        </li>
                        <!-- CREDIT -->
                        <li class="nav-item mt-2">
                            <a class="nav-link" data-bs-toggle="tab" href="#credits-tab">
                                <h4>Credits</h4>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7 order-1 order-lg-2">
                    <div class="tab-content">
                        <!-- PROFILE -->
                        <div class="tab-pane active show" id="profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form class="ajax-form" method="POST" action="{{ route('frontend.profile.update', ['user' => $user]) }}" role="form">
                                        @csrf
                                        @method('PUT')
                                        <!-- NAME -->
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">@lang('user.fields.first_name')</label>
                                            <input type="text" class="form-control"
                                                   name="first_name"
                                                   id="first_name"
                                                   placeholder="@lang('user.fields.first_name')"
                                                   value="{{ $user->first_name }}"
                                            />
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <!-- LAST_NAME -->
                                        <div class="form-group mt-3">
                                            <label for="last_name" class="form-label">@lang('user.fields.last_name')</label>
                                            <input type="text" class="form-control"
                                                   name="last_name"
                                                   id="last_name"
                                                   placeholder="@lang('user.fields.last_name')"
                                                   value="{{ $user->last_name }}"
                                            />
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <!-- NICKNAME -->
                                        <div class="form-group mt-3">
                                            <label for="nickname" class="form-label">@lang('user.fields.nickname')</label>
                                            <input type="text" class="form-control"
                                                   name="nickname"
                                                   id="nickname"
                                                   placeholder="@lang('user.fields.nickname')"
                                                   value="{{ $user->nickname }}"
                                            />
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <!-- EMAIL -->
                                        <div class="form-group mt-3">
                                            <label for="email" class="form-label">@lang('user.fields.email')</label>
                                            <input type="email" class="form-control"
                                                   name="email"
                                                   id="email"
                                                   placeholder="@lang('user.fields.email')"
                                                   value="{{ $user->email }}"
                                            />
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <!-- MOBILE -->
                                        <div class="form-group mt-3">
                                            <label for="mobile" class="form-label">@lang('user.fields.mobile')</label>
                                            <input type="tel" class="form-control"
                                                   name="mobile"
                                                   id="mobile"
                                                   placeholder="@lang('user.fields.mobile')"
                                                   value="{{ $user->mobile }}"
                                            />
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <!-- DATE_OF_BIRTH -->
                                        <div class="form-group mt-3">
                                            <label for="birth_date" class="form-label">@lang('user.fields.birth_date')</label>
                                            <input type="date"
                                                   class="form-control date"
                                                   name="birth_date"
                                                   id="birth_date"
                                                   placeholder="@lang('user.fields.birth_date')"
                                                   value="{{ $user->birth_date?->toDateString() }}"
                                            />
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="border-bottom border-2 border-light mt-4 mb-2"></div>

                                        <!-- PASSWORD & CONFIRMATION -->
                                        <div class="form-group mt-3">
                                            <label for="password">@lang('user.fields.password')</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="@lang('user.fields.password')"/>
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="password_confirmation">@lang('user.fields.password_confirmation')</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="@lang('user.fields.password_confirmation')"/>
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <a href="javascript: void(0);" class="btn btn-light me-2">
                                                @lang('general.actions.cancel')
                                            </a>
                                            <button type="submit" class="btn btn-secondary submit-btn">
                                                @lang('general.actions.update') <i class="fa fa-spinner fa-spin d-none"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- CREDITS -->
                        <div class="tab-pane" id="credits-tab">
                            <figure>
                                <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" alt="" class="img-fluid">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Features Section -->
@endsection
