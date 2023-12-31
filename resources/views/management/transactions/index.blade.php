@extends('_layouts.app', [
    'title' => __('transaction.plural'),
])
@section('before-styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" type="text/css" />
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('transaction.plural')</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('transaction.plural')</h4>
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        <a href="javascript:void(0);" id="datatable-reset-filter" class="btn btn-outline-warning tippy-btn mr-1" title="@lang('general.actions.clear_filter')">
                            <i class="fa fa-broom"></i> @lang('general.actions.clear_filter')
                        </a>
                        <a href="javascript:void(0);" id="datatable-filter" class="btn btn-outline-success tippy-btn mr-1" title="@lang('general.filter')">
                            <i class="fa fa-filter"></i> @lang('general.actions.filter')
                        </a>
                        @can('create', \App\Models\Transaction::class)
                            <a href="{{route('management.transactions.create')}}" class="btn btn-outline-primary tippy-btn" title="@lang('transaction.actions.create')">
                                <i class="fa fa-plus"></i> @lang('transaction.actions.create')
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ajax-datatable" class="table table-condensed table-bordered table-nowrap w-100" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr role="row"  class="bg-light">
                                    <th scope="col">@lang('transaction.fields.id')</th>
                                    <th scope="col">@lang('transaction.fields.user_id')</th>
                                    <th scope="col">@lang('transaction.fields.name')</th>
                                    <th scope="col">@lang('transaction.fields.type')</th>
                                    <th scope="col">@lang('transaction.fields.credit')</th>
                                    <th scope="col">@lang('transaction.fields.debit')</th>
                                    <th scope="col">@lang('transaction.fields.created_at')</th>
                                    <th scope="col">@lang('general.actions.plural')</th>
                                </tr>
                                <tr role="row" style="display: none;">
                                    <th></th>
                                    <th>
                                        <select class="form-control search-input select2" name="user_id" id="user_id"
                                                style="width: 100% !important;"
                                                aria-label="@lang('transaction.fields.user_id')"
                                                data-placeholder="@lang('transaction.fields.user_id')"
                                                data-allow-clear="true"
                                        ></select>
                                    </th>
                                    <th><input type="text" class="form-control search-input" name="name" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th>
                                        <select class="form-control select2 search-input" name="type"
                                                data-allow-clear="true"
                                                data-placeholder="@lang('transaction.fields.type')" style="width: 100%">
                                            <option value="">@lang('transaction.fields.type')</option>
                                            @foreach(\App\Enums\TransactionTypeEnum::cases() as $type)
                                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th><input type="text" class="form-control search-input" name="credit" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th><input type="text" class="form-control search-input" name="debit" placeholder="@lang('general.actions.search')" aria-label="@lang('general.actions.search')"></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot id="footer-table"></tfoot>
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

            let $userSelect = $('#user_id');

            let dt = $datatable.DataTable({
                responsive: false,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                stateSave: true,
                order: [[0, 'asc']],
                ajax: '{{ route('management.transactions.index') }}',
                deferRender: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
                    // {data: 'companies', name: 'companies', render: '[<br>].name', orderable: false, defaultContent: '---'},
                    {data: 'credit', name: 'credit'},
                    {data: 'debit', name: 'debit'},
                    {data: 'created_at', name: 'created_at'},
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

                    let html = '';
                    $.each(settings.json.model_aggregates, function(index, value) {
                        html += `<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="bg-info bg-opacity-10 fw-lighter fs-6">${value.type_label}</td>
                            <td class="bg-success bg-opacity-10 fw-lighter">${value.total_credit}</td>
                            <td class="bg-warning bg-opacity-10 fw-lighter">${value.total_debit}</td>
                            <td></td>
                            <td></td>
                        </tr>`;
                    });
                    $('#ajax-datatable #footer-table').html(html);
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

                        if ($field.attr('id') === 'user_id') {
                            fillSelect2Element(columnSearchValue, "{{ route('management.users.search') }}", $userSelect);
                        } else if($field.hasClass('select2-hidden-accessible')) {
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

            $userSelect.select2({
                placeholder: "@lang('user.actions.search')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.users.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: $.map(data, function (response) {
                                return {
                                    id: response.id,
                                    text: response.label,
                                };
                            })
                        };
                    },
                    cache: false,
                }
            });
        });
    </script>
@endsection

