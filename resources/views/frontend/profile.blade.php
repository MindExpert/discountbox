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
                <div class="col-lg-5 mt-2 order-1 order-lg-1">
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
                                <h4>@lang('user.credit')</h4>
                            </a>
                        </li>
                        <!-- MY_DISCOUNTBOX_AWARDED -->
                        <li class="nav-item mt-2">
                            <a class="nav-link" data-bs-toggle="tab" href="#discount-box-awarded-tab">
                                <h4>@lang('user.my_discount_box_awarded')</h4>
                            </a>
                        </li>
                        <!-- MY_DISCOUNTBOX_PROGRESS -->
                        <li class="nav-item mt-2">
                            <a class="nav-link" data-bs-toggle="tab" href="#discount-box-progress-tab">
                                <h4>@lang('user.my_discount_box_progress')</h4>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7 order-2 order-lg-2">
                    <div class="tab-content">
                        <!-- PROFILE -->
                        @include('frontend._partials.tab-profile')

                        <!-- CREDITS -->
                        @include('frontend._partials.tab-credits', ['credits' => $user->transactions])

                        <!-- MY_DISCOUNTBOX_AWARDED -->
                        @include('frontend._partials.tab-discount-box-awarded', ['discount_boxes_awarded' => $user->discount_requests])

                        <!-- MY_DISCOUNTBOX_PROGRESS -->
                        @include('frontend._partials.tab-discount-box-progress', ['discount_boxes_progress' => $user->pending_discount_requests])

                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Features Section -->
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('a[data-bs-toggle="tab"]').click(function () {
                if (window.history.pushState) {
                    window.history.pushState('', '', '{{ route('frontend.profile.edit') }}'+$(this).attr('href'));
                }
            });

            function activateTabByHash() {
                if(window.location.hash) {
                    $('a[data-bs-toggle="tab"][href="' + window.location.hash + '"]').tab('show');
                } else {
                    $('a[data-bs-toggle="tab"][href="profile-tab"]').tab('show');
                }
            }

            activateTabByHash();

            if (window.history && window.history.pushState) {
                window.addEventListener("popstate", function(event) {
                    activateTabByHash();
                }, false);
            }
        });
    </script>
@endsection
