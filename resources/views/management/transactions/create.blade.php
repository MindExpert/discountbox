@extends('_layouts.app', [
    'title'           => __('transaction.actions.create_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.transactions.index') }}">@lang('transaction.plural')</a></li>
    <li class="breadcrumb-item active">@lang('transaction.actions.create')</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header border-info border-3">
                    <h4 class="card-title">@lang('transaction.actions.create_model')</h4>
                </div>
                <form class="ajax-form" method="POST" action="{{ route('management.transactions.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- USER -->
                            <div class="col-md-5">
                                <div class="form-group mb-3">
                                    <label for="user_id" class="form-label">@lang('transaction.fields.user_id')</label>
                                    <select class="form-control select2" name="user_id" id="user_id"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('transaction.fields.select_user')" style="width: 100%">
                                        <option value="">@lang('transaction.fields.select_user')</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- AMOUNT -->
                            <div class="col-md-5">
                                <label for="amount" class="form-label">@lang('transaction.fields.amount')</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="amount" id="amount" placeholder="@lang('transaction.fields.amount')">
                                    <div class="input-group-text type-placeholder"></div>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- TYPE -->
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">@lang('transaction.fields.type')</label>
                                    <select class="form-control select2" name="type" id="type"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('transaction.fields.type')" style="width: 100%">
                                        <option value="">@lang('transaction.fields.type')</option>
                                        <option value="credit">@lang('transaction.fields.credit')</option>
                                        <option value="debit">@lang('transaction.fields.debit')</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- NOTE -->
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="notes" class="form-label">@lang('transaction.fields.notes')</label>
                                    <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="@lang('transaction.fields.notes')"></textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-outline-primary mr-1 submit-btn">
                                @lang('transaction.actions.create_model')<i class="fa fa-spinner fa-spin d-none"></i>
                            </button>
                            <a href="{{route('management.transactions.index')}}" class="btn btn-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
                                @lang('general.actions.back')
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            let $type       = $('#type'),
                $userSelect = $('#user_id');

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
                            results: $.map(data, function (user) {
                                return {
                                    id: user.id,
                                    text: user.label,
                                };
                            })
                        };
                    },
                    cache: false,
                }
            });

            $type.on('select2:select', function () {
                let type = $(this).val();
                if (type === 'credit') {
                    $('.type-placeholder').html("<i class='bx bx-plus-medical'></i>");
                } else {
                    $('.type-placeholder').html("<i class='bx bx-minus'></i>");
                }
            });

            // on clear type, clear discount text field
            $type.on('select2:clear', function () {
                $('.type-placeholder').text('');
            });
        });
    </script>
@endsection
