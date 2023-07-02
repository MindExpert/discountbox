@if($product->getFirstMediaUrl('featured_image'))
{{--    <a href="javascript:void(0);"--}}
{{--       data-model-id="{{$product->id}}"--}}
{{--       data-tippy-content="@lang('product.fields.featured_image')"--}}
{{--       class="dt-tippy-btn js-init-dynamic-modal-product-image"--}}
{{--    >--}}
{{--        <img src="{{ $product->getFirstMediaUrl('featured_image') }}"--}}
{{--             alt="{{$product->serial}}"--}}
{{--             class="rounded-circle avatar-md"--}}
{{--             loading="lazy"--}}
{{--             style="object-fit: cover; height: 30px; width: 30px"--}}
{{--        >--}}
{{--    </a>--}}
    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view-product-image-modal-{{$product->id}}">
        <img src="{{ $product->getFirstMediaUrl('featured_image') }}" alt="" style="object-fit: cover; height: 24px; width: 24px" class="rounded-circle" loading="lazy">
    </a>
@else
    <img src="{{ asset('frontend/assets/img/placeholderx1.png') }}"
         alt="{{$product->serial}}"
         class="rounded-circle avatar-md dt-tippy-btn"
         loading="lazy"
         data-tippy-content="@lang('product.no_featured_image')"
         style="object-fit: cover; height: 30px; width: 30px"
    >
@endif
@include('management.products._partials.product-image')
