@extends('_layouts.app', [
    'title'           => __('coupon.actions.create_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.coupons.index') }}">@lang('coupon.plural')</a></li>
    <li class="breadcrumb-item active">@lang('coupon.actions.create')</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header border-info border-3">
                    <h4 class="card-title">@lang('coupon.actions.create_model')</h4>
                </div>
                <form class="ajax-form" method="POST" action="{{ route('management.coupons.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <!-- CODE -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="code" class="form-label">@lang('coupon.fields.code')</label>
                                    <input type="text" class="form-control" name="code" id="code" placeholder="@lang('coupon.fields.code')"/>
                                    <small class="text-muted">@lang('coupon.fields.code_info')</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- DISCOUNT_TYPE -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">@lang('coupon.fields.type')</label>
                                    <select class="form-control select2" name="type" id="type"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('coupon.fields.select_type')" style="width: 100%">
                                        <option value="">@lang('coupon.fields.select_type')</option>
                                        @foreach(\App\Enums\DiscountTypeEnum::cases() as $type)
                                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- DISCOUNT -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="discount" class="form-label">@lang('coupon.fields.discount')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="discount" id="discount" placeholder="@lang('coupon.fields.discount')"/>
                                        <div class="input-group-text discount-type"></div>
                                        <span class="invalid-feedback"></span>
                                    </div>
                                    <small class="text-muted">@lang('coupon.fields.discount_info')</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- VALID_FROM -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="valid_from" class="form-label">@lang('coupon.fields.valid_from')</label>
                                    <input type="date" class="form-control date" name="valid_from" id="valid_from" placeholder="@lang('coupon.fields.valid_from')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- EXPIRES_AT -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="expires_at" class="form-label">@lang('coupon.fields.expires_at')</label>
                                    <input type="date" class="form-control date" name="expires_at" id="expires_at" placeholder="@lang('coupon.fields.expires_at')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- USER_ID -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="user_id" class="form-label">@lang('coupon.fields.user_id')</label>
                                    <select class="form-control select2" name="user_id" id="user_id"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('coupon.fields.select_user')" style="width: 100%">
                                        <option value="">@lang('coupon.fields.select_user')</option>
                                    </select>
                                    <small class="text-muted">@lang('coupon.fields.user_info')</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-outline-primary mr-1 submit-btn">
                                @lang('coupon.actions.create_model')<i class="fa fa-spinner fa-spin d-none"></i>
                            </button>
                            <a href="{{route('management.coupons.index')}}" class="btn btn-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
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
            let $type        = $('#type');
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
                if (type === '{{ \App\Enums\DiscountTypeEnum::PERCENTAGE->value }}') {
                    $('.discount-type').text('%');
                } else {
                    $('.discount-type').text('€');
                }
            });

            // on clear type, clear discount text field
            $type.on('select2:clear', function () {
                $('.discount-type').text('');
            });
        });
    </script>
@endsection
