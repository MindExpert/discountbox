@extends('_layouts.app', [
    'title'           => __('discount_box.actions.create_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.discount-boxes.index') }}">@lang('discount_box.plural')</a></li>
    <li class="breadcrumb-item active">@lang('discount_box.actions.create')</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-info border-3">
                    <h4 class="card-title">@lang('discount_box.actions.create_model')</h4>
                </div>
                <form class="ajax-form" method="POST" action="{{ route('management.discount-boxes.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <!-- NAME -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">@lang('discount_box.fields.name')</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="@lang('discount_box.fields.name')"/>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- PRICE -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">@lang('discount_box.fields.price')</label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="@lang('discount_box.fields.price')"/>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">@lang('discount_box.fields.status')</label>
                                    <select class="form-control select2" name="status" id="status"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('discount_box.fields.select_status')" style="width: 100%">
                                        <option value="">@lang('discount_box.fields.select_status')</option>
                                        @foreach(\App\Enums\StatusEnum::cases() as $type)
                                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- COUPON_ID -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="coupon_id" class="form-label">@lang('discount_box.fields.coupon_id')</label>
                                    <select class="form-control select2" name="coupon_id" id="coupon_id"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('discount_box.fields.select_coupon')" style="width: 100%">
                                        <option value="">@lang('discount_box.fields.select_coupon')</option>
                                    </select>
                                    <small class="text-muted">@lang('discount_box.fields.coupon_info')</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- EXPIRES_AT -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="expires_at" class="form-label">@lang('discount_box.fields.expires_at')</label>
                                    <input type="date" class="form-control date" name="expires_at" id="expires_at" placeholder="@lang('discount_box.fields.expires_at')"/>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- CREDIT -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="credit" class="form-label">@lang('discount_box.fields.credit')</label>
                                    <input type="number" class="form-control" name="credit" id="credit" placeholder="@lang('discount_box.fields.credit')"/>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- HIGHLIGHTED -->
                            <div class="col-md-6">
                                <div class="form-check form-switch form-switch-lg mt-2 mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="highlighted" name="highlighted" value="1">
                                    <label class="form-check-label" for="highlighted">@lang('discount_box.fields.highlighted')</label>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- SHOW_ON_HOME -->
                            <div class="col-md-6">
                                <div class="form-check form-switch form-switch-lg mt-2 mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="show_on_home" name="show_on_home" value="1">
                                    <label class="form-check-label" for="show_on_home">@lang('discount_box.fields.show_on_home')</label>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- COVER_IMAGE -->
                            <div class="col-md-6 cover_image-wrapper">
                                <div class="form-group mb-3">
                                    <label class="fw-bold fs-6 mb-2" for="cover_image">
                                        @lang('discount_box.fields.cover_image')
                                    </label>
                                    <x-media-library-attachment
                                        name="cover_image"
                                        max-items="1"
                                        rules="mimes:jpg,jpeg,png,svg,gif|max:3072"
                                    />
                                </div>
                            </div>

                            <!-- PRODUCTS MULTI-SELECT -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="products" class="form-label">@lang('discount_box.fields.products')</label>
                                    <select class="form-control select2" name="products[]" id="products" multiple
                                            data-allow-clear="true"
                                            data-placeholder="@lang('discount_box.fields.select_products')" style="width: 100%">
                                        <option value="">@lang('discount_box.fields.select_products')</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-10">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-outline-primary mr-1 submit-btn">
                                @lang('product.actions.create_model')<i class="fa fa-spinner fa-spin d-none"></i>
                            </button>
                            <a href="{{route('management.discount-boxes.index')}}" class="btn btn-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
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
            let $couponSelect  = $('#coupon_id'),
                $productSelect = $('#products');

            $couponSelect.select2({
                placeholder: "@lang('coupon.actions.search')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.coupons.search') }}",
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

            $productSelect.select2({
                placeholder: "@lang('product.actions.search')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.products.search') }}",
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

            initTinymce('#description');

            function initTinymce(selector) {
                tinymce.init({
                    selector: selector,
                    toolbar: 'undo redo | formatselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | outdent indent',
                    setup: function (editor) {
                        editor.on('change', function () {
                            tinymce.triggerSave();
                        });
                    },
                    height: 240,
                });
            }
        });
    </script>
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
@endsection
