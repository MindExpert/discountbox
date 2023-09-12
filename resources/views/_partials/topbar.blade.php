<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('management.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('/assets/images/logo.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('/assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="{{ route('management.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('/assets/images/logo-light.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('/assets/images/logo-light.png') }}" alt="" height="19">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
{{--            <div class="dropdown d-inline-block">--}}
{{--                @php($sessionLocale = session()->get('locale'))--}}
{{--                <button type="button" class="btn header-item waves-effect"--}}
{{--                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    @switch($sessionLocale)--}}
{{--                        @case('it')--}}
{{--                            <img src="{{ asset('/assets/images/flags/it.jpg')}}" alt="Header Language" height="16">--}}
{{--                            @break--}}
{{--                        @default--}}
{{--                            <img src="{{ asset('/assets/images/flags/en.jpg')}}" alt="Header Language" height="16">--}}
{{--                    @endswitch--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu dropdown-menu-end">--}}
{{--                    @foreach(config('app.locales') as $locale)--}}
{{--                        <form class="inline" action="{{ route('languages.update') }}" method="POST">--}}
{{--                            @csrf--}}
{{--                            @method('PUT')--}}
{{--                            <input type="hidden" name="locale" value="{{ $locale }}">--}}
{{--                            <!-- item-->--}}
{{--                            <button type="submit" class="dropdown-item notify-item language" data-lang="eng">--}}
{{--                                <img src="{{ asset ("/assets/images/flags/$locale.jpg") }}" alt="user-image" class="me-1" height="12"> <span class="align-middle">@lang("general.locales.{$locale}")</span>--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    @endforeach--}}
{{--                    <!-- item-->--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset ('/assets/images/users/avatar-1.jpg') }}"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ ucfirst(Auth::user()->name) }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span>@lang('user.profile')</span></a>
                    <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span>@lang('user.my_wallet')</span></a>
                    <a class="dropdown-item" href="{{ route('homepage') }}"><i class="bx bx-planet font-size-16 align-middle me-1"></i> <span>@lang('general.home')</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item d-block text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#partial-logout-modal">
                        <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                        <span class="align-middle">@lang('general.actions.logout')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
