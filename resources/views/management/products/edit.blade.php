@extends('_layouts.app', [
    'title'           => __('product.actions.edit_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.products.index') }}">@lang('product.plural')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.products.show', ['product' => $product->id]) }}">{{ $product->label }}</a></li>
    <li class="breadcrumb-item active">@lang('product.actions.edit')</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-info border-3">
                    <h4 class="card-title">@lang('product.actions.edit_model')</h4>
                </div>
                <form class="ajax-form"
                      method="POST"
                      action="{{ route('management.products.update', ['product' => $product]) }}"
                      enctype="multipart/form-data"
                      onkeydown="return event.key !== 'Enter';"
                      novalidate>
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- NAME -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">@lang('product.fields.name')</label>
                                    <input type="text"
                                           class="form-control"
                                           name="name"
                                           id="name"
                                           placeholder="@lang('product.fields.name')"
                                           value="{{ $product->name }}"
                                    />
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- URL -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="url" class="form-label">@lang('product.fields.url')</label>
                                    <input type="url" class="form-control"
                                           name="url"
                                           id="url"
                                           placeholder="@lang('product.fields.url')"
                                            value="{{ $product->url }}"
                                    />
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">@lang('product.fields.description')</label>
                                    <textarea class="form-control"
                                              name="description"
                                              id="description"
                                              placeholder="@lang('product.fields.description')"
                                              rows="5"
                                    >{!! $product->description !!}</textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- REVIEW -->
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="review" class="form-label">@lang('product.fields.review')</label>
                                    <textarea class="form-control"
                                              name="review"
                                              id="review"
                                              placeholder="@lang('product.fields.review')"
                                              rows="5"
                                    >{!! $product->review !!}</textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- HIGHLIGHTED -->
                            <div class="col-md-6">
                                <div class="form-check form-switch form-switch-lg mt-2 mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="highlighted" name="highlighted" value="1" @checked($product->highlighted) />
                                    <label class="form-check-label" for="highlighted">@lang('product.fields.highlighted')</label>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- SHOW_ON_HOME -->
                            <div class="col-md-6">
                                <div class="form-check form-switch form-switch-lg mt-2 mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="show_on_home" name="show_on_home" value="1" @checked($product->show_on_home) />
                                    <label class="form-check-label" for="show_on_home">@lang('product.fields.show_on_home')</label>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <!-- FEATURED_IMAGE -->
                            <div class="col-md-6 featured_image-wrapper">
                                <div class="form-group mb-3">
                                    <label class="fw-bold fs-6 mb-2" for="featured_image">
                                        @lang('product.fields.featured_image')
                                    </label>
                                    <x-media-library-collection
                                        name="featured_image"
                                        :model="$product"
                                        collection="featured_image"
                                        max-items="1"
                                        rules="mimes:jpg,jpeg,png,svg,gif|max:3072"
                                    />
                                </div>
                            </div>

                            <!-- GALLERY_IMAGE -->
                            <div class="col-md-6 gallery_images-wrapper">
                                <div class="form-group mb-3">
                                    <label class="fw-bold fs-6 mb-2" for="gallery_images">
                                        @lang('product.fields.gallery_images')
                                    </label>
                                    <x-media-library-collection
                                        name="gallery_images"
                                        :model="$product"
                                        collection="gallery_images"
                                        multiple
                                        max-items="10"
                                        rules="mimes:jpg,jpeg,png,svg,gif|max:3072"
                                    />
                                </div>
                            </div>

                            {{--<!-- STATUS -->--}}
                            {{--<div class="col-md-6">--}}
                            {{--    <div class="form-group mb-3">--}}
                            {{--        <label for="status" class="form-label">@lang('product.fields.status')</label>--}}
                            {{--        <select class="form-control select2" name="status" id="status"--}}
                            {{--                data-allow-clear="true"--}}
                            {{--                data-placeholder="@lang('product.fields.select_status')" style="width: 100%">--}}
                            {{--            <option value="">@lang('product.fields.select_status')</option>--}}
                            {{--            @foreach(\App\Enums\StatusEnum::cases() as $type)--}}
                            {{--                <option value="{{ $type->value }}">{{ $type->label() }}</option>--}}
                            {{--            @endforeach--}}
                            {{--        </select>--}}
                            {{--        <span class="invalid-feedback"></span>--}}
                            {{--    </div>--}}
                            {{--</div>--}}

                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-10">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-outline-primary mr-1 submit-btn">
                                @lang('product.actions.edit_model')<i class="fa fa-spinner fa-spin d-none"></i>
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
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let $description = $('#description'),
                $review      = $('#review'),
                $userSelect  = $('#assignee_id');

            initTinymce('#description');
            initTinymce('#review');


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
@endsection
