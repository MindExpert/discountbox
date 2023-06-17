<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">{{ $title ?? '' }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @yield('breadcrumbs')
{{--                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>--}}
{{--                    <li class="breadcrumb-item active">Starter</li>--}}
                </ol>
            </div>
        </div>
    </div>
</div>
