<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('management.dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
                        </span>
                    </a>

                    <a href="{{ route('management.dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="header-lang-img" src="assets/images/flags/us.svg" alt="Header Language" height="20" class="rounded">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                            <img src="assets/images/flags/us.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                            <img src="assets/images/flags/spain.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Española</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr" title="German">
                            <img src="assets/images/flags/germany.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">Deutsche</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                            <img src="assets/images/flags/italy.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Italiana</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                            <img src="assets/images/flags/russia.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">русский</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                            <img src="assets/images/flags/china.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">中国人</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="fr" title="French">
                            <img src="assets/images/flags/french.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">français</span>
                        </a>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Anna Adame</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome Anna!</h6>
                        <a class="dropdown-item" href="javascript:void(0);"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="javascript:void(0);"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0);"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Credits : <b>597</b></span></a>
                        <a class="dropdown-item" href="javascript:void(0);"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#partial-logout-modal">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
