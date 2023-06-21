<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('sidebar.menu.dashboard')</li>
                <li>
                    <a href="{{ route('management.dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>@lang('sidebar.menu.dashboard')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('management.users.index') }}" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span>@lang('sidebar.menu.users')</span>
                    </a>
                </li>

                <li class="menu-title">@lang('management.apps')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-share-alt"></i>
                        <span >@lang('Multi Level')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);">@lang('Level_1.1')</a></li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">@lang('Level_1.2')</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">@lang('Level_2.1')</a></li>
                                <li><a href="javascript: void(0);">@lang('Level_2.2')</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
