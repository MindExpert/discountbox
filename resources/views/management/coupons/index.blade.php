@extends('_layouts.app', [
    'title' => __('coupon.plural'),
])
@section('before-styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" type="text/css" />
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('coupon.plural')</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('coupon.plural')</h4>
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        <a href="javascript:void(0);" id="datatable-reset-filter" class="btn btn-outline-warning tippy-btn mr-1" title="@lang('general.actions.clear_filter')">
                            <i class="fa fa-broom"></i> @lang('general.actions.clear_filter')
                        </a>
                        <a href="javascript:void(0);" id="datatable-filter" class="btn btn-outline-success tippy-btn mr-1" title="@lang('general.filter')">
                            <i class="fa fa-filter"></i> @lang('general.actions.filter')
                        </a>
                        @can('create', \App\Models\Coupon::class)
                            <a href="{{route('management.coupons.create')}}" class="btn btn-outline-primary tippy-btn" title="@lang('User.actions.create')">
                                <i class="fa fa-plus"></i> @lang('coupon.actions.create')
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ajax-datatable" class="table table-sm table-bordered table-nowrap w-100" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr role="row"  class="bg-light">
                                    <th scope="col">@lang('coupon.fields.id')</th>
                                    <th scope="col">@lang('coupon.fields.code')</th>
                                    <th scope="col">@lang('coupon.fields.type')</th>
                                    <th scope="col">@lang('coupon.fields.discount')</th>
                                    <th scope="col">@lang('coupon.fields.valid_from')</th>
                                    <th scope="col">@lang('coupon.fields.expires_at')</th>
                                    <th scope="col">@lang('coupon.fields.applied_at')</th>
                                    <th scope="col">@lang('general.actions.plural')</th>
                                </tr>
                                <tr role="row" style="display: none;">
                                    <th></th>
                                    <th><input type="text" class="form-control search-input" name="code" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th><input type="text" class="form-control search-input" name="type" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th><input type="text" class="form-control search-input" name="discount" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th><input type="text" class="form-control search-input" name="valid_from" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th><input type="text" class="form-control search-input" name="expires_at" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th><input type="text" class="form-control search-input" name="applied_at" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Required datatable js -->
    <script src="{{ asset('/assets/libs/datatables/datatables.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            let $datatable = $('#ajax-datatable');
            let $filterBtn = $('#datatable-filter');
            let $resetFilterBtn = $('#datatable-reset-filter');
            let hasFilters = false;

            let dt = $datatable.DataTable({
                responsive: false,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                stateSave: true,
                order: [[0, 'asc']],
                ajax: '{{ route('management.coupons.index') }}',
                deferRender: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'code', name: 'full_name'},
                    {data: 'type', name: 'role'},
                    // {data: 'companies', name: 'companies', render: '[<br>].name', orderable: false, defaultContent: '---'},
                    {data: 'discount', name: 'discount'},
                    {data: 'valid_from', name: 'valid_from'},
                    {data: 'expires_at', name: 'expires_at'},
                    {data: 'applied_at', name: 'applied_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                drawCallback: function (settings) {
                    tippy('.dt-tippy-btn', {
                        arrow: true,
                        animation: 'fade'
                    });

                    $('body').popover({
                        selector: '.dt-popover-el',
                        trigger: 'hover',
                        html: true,
                        animation: false,
                        minWidth: 16,
                        minHeight: 16,
                        maxWidth: 'calc(50% - 32px)',
                        maxHeight: 'calc(50% - 32px)',
                    });
                },
            });

            $datatable.find('thead tr:eq(1) th').each(function () {
                $('.search-input', this).on('keyup change', function () {
                    if (dt.column(`${this.name}:name`).search() !== this.value) {
                        dt.column(`${this.name}:name`).search(this.value).draw();
                    }
                });
            });

            $filterBtn.click(function () {
                $datatable.find('thead tr:eq(1)').toggle();
            })

            $resetFilterBtn.click(function () {
                dt.state.clear();
                location.reload();
            });

            if (dt.state.loaded()) {
                let state = dt.state.loaded();
                let columns = dt.settings().init().columns;

                dt.columns().every(function (index) {
                    let columnName = columns[index].name,
                        columnSearch = state.columns[index].search,
                        columnSearchValue = columnSearch ? columnSearch.search : null;

                    if (columnSearchValue) {
                        let $field = $(`.search-input[name="${columnName}"]`);

                        if($field.hasClass('select2-hidden-accessible')) {
                            $field.val(columnSearchValue).trigger('change.select2');
                        } else {
                            $field.val(columnSearchValue);
                        }
                        hasFilters = true;
                    }

                });
            }

            if (hasFilters) {
                $datatable.find('thead tr:eq(1)').show();
            }
        });
    </script>
@endsection

