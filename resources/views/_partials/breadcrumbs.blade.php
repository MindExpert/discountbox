<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h5 class="mb-sm-0">{{ $title ?? '' }}</h5>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @yield('breadcrumbs')
                </ol>
            </div>
        </div>
    </div>
</div>
