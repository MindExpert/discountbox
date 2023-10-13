@extends('_layouts.app', [
    'title'           => __('discount_request.actions.create_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.discount-requests.index') }}">@lang('discount_request.plural')</a></li>
    <li class="breadcrumb-item active">@lang('discount_request.actions.create')</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3">
                    <h4 class="card-title">@lang('discount_request.actions.create_model')</h4>
                </div>
                <form class="ajax-form" method="POST" action="{{ route('management.discount-requests.store') }}" novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- USER_ID -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="user_id" class="form-label">@lang('discount_request.fields.user_id')</label>
                                    <select class="form-control select2" name="user_id" id="user_id"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('discount_request.fields.select_user')" style="width: 100%">
                                        <option value="">@lang('discount_request.fields.select_user')</option>
                                    </select>
                                    <small class="text-muted">@lang('discount_request.fields.user_info')</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- DISCOUNT_BOX SELECT -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="discount_box_id" class="form-label">@lang('discount_request.fields.discount_box_id')</label>
                                    <select class="form-control select2" name="discount_box_id" id="discount_box_id"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('discount_request.fields.select_discount_box')" style="width: 100%">
                                        <option value="">@lang('discount_request.fields.select_discount_box')</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- PERCENTAGE -->
                            <div class="col-md-6">
                                <label for="percentage" class="form-label">@lang('discount_request.fields.percentage')</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="percentage" id="percentage" placeholder="@lang('discount_request.fields.percentage')">
                                    <div class="input-group-text type-placeholder">
                                        %
                                    </div>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-10">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-outline-primary mr-1 submit-btn">
                                @lang('discount_request.actions.create_model')<i class="fa fa-spinner fa-spin d-none"></i>
                            </button>
                            <a href="{{route('management.discount-requests.index')}}" class="btn btn-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
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
            let $userSelect  = $('#user_id'),
                $discountBoxSelect = $('#discount_box_id');

            $userSelect.select2({
                placeholder: "@lang('user.actions.search')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.users.search', ['only_active' => true]) }}",
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

            $discountBoxSelect.select2({
                placeholder: "@lang('discount_box.actions.search')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.discount-boxes.search') }}",
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
                                    serial: response.serial,
                                    name: response.name,
                                    thumbnail: response.thumbnail
                                };
                            })
                        };
                    },
                    cache: false,
                },
                templateResult: function (data) {
                    if (! data.id) {
                        return data.text;
                    }

                    let $container = $(`
                        <div class="py-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 align-self-center me-3">
                                    <img src="${data.thumbnail}" alt="" class="avatar-xs rounded-circle" loading="lazy">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="font-size-15 mb-1">${data.serial}</h5>
                                    <p class="text-muted mb-0">${data.name}</p>
                                </div>
                            </div>
                        </div>
                    `);
                    return $container;
                },
            });
        });
    </script>
@endsection
