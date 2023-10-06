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
                @can('viewAny', App\Models\User::class)
                    <li>
                        <a href="{{ route('management.users.index') }}" class="waves-effect">
                            <i class="bx bx-user"></i>
                            <span>@lang('sidebar.menu.users')</span>
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\Coupon::class)
                    <li>
                        <a href="{{ route('management.coupons.index') }}" class="waves-effect">
                            <i class="bx bxs-discount"></i>
                            <span>@lang('sidebar.menu.coupons')</span>
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\Product::class)
                    <li>
                        <a href="{{ route('management.products.index') }}" class="waves-effect">
                            <i class="bx bx-package"></i>
                            <span>@lang('sidebar.menu.products')</span>
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\DiscountBox::class)
                    <li>
                        <a href="{{ route('management.discount-boxes.index') }}" class="waves-effect">
                            <i class="bx bx-box"></i>
                            <span>@lang('sidebar.menu.discount_box')</span>
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\Transaction::class)
                    <li>
                        <a href="{{ route('management.transactions.index') }}" class="waves-effect">
                            <i class="bx bx-transfer"></i>
                            <span>@lang('sidebar.menu.transactions')</span>
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\DiscountRequest::class)
                    <li>
                        <a href="{{ route('management.discount-requests.index') }}" class="waves-effect">
                            <i class="bx bx-file"></i>
                            <span>@lang('sidebar.menu.discount_requests')</span>
                        </a>
                    </li>
                @endcan
                <li class="menu-title">@lang('More')</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-share-alt"></i>
                        <span>@lang('Multi Level')</span>
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
