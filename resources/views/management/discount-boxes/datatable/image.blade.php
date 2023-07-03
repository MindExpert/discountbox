@if($discountBox->getFirstMediaUrl('cover_image'))
    {{--    <a href="javascript:void(0);"--}}
    {{--       data-model-id="{{$discountBox->id}}"--}}
    {{--       data-tippy-content="@lang('product.fields.cover_image')"--}}
    {{--       class="dt-tippy-btn js-init-dynamic-modal-product-image"--}}
    {{--    >--}}
    {{--        <img src="{{ $discountBox->getFirstMediaUrl('cover_image') }}"--}}
    {{--             alt="{{$discountBox->serial}}"--}}
    {{--             class="rounded-circle avatar-md"--}}
    {{--             loading="lazy"--}}
    {{--             style="object-fit: cover; height: 30px; width: 30px"--}}
    {{--        >--}}
    {{--    </a>--}}
    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view-cover-image-modal-{{$discountBox->id}}">
        <img src="{{ $discountBox->getFirstMediaUrl('cover_image', 'thumb') }}" alt=""
             style="object-fit: cover; height: 24px; width: 24px" class="rounded-circle" loading="lazy">
    </a>
@else
    <img src="{{ asset('frontend/assets/img/placeholderx1.png') }}"
         alt="{{$discountBox->serial}}"
         class="rounded-circle avatar-md dt-tippy-btn"
         loading="lazy"
         data-tippy-content="@lang('discount_box.no_cover_image')"
         style="object-fit: cover; height: 30px; width: 30px"
    >
@endif
@include('management.discount-boxes._partials.cover-image-modal')
