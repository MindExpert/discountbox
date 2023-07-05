@if($discountBox->getFirstMediaUrl('cover_image'))
{{--        <a href="javascript:void(0);"--}}
{{--           data-model-id="{{$discountBox->id}}"--}}
{{--           data-tippy-content="@lang('discount_box.fields.cover_image')"--}}
{{--           class="dt-tippy-btn js-init-dynamic-modal-cover-image"--}}
{{--        >--}}
{{--            <img src="{{ $discountBox->getFirstMediaUrl('cover_image', 'thumb') }}"--}}
{{--                 alt="{{$discountBox->serial}}"--}}
{{--                 class="rounded-circle avatar-md"--}}
{{--                 loading="lazy"--}}
{{--                 style="object-fit: cover; height: 30px; width: 30px"--}}
{{--            >--}}
{{--        </a>--}}
    <a href="javascript:void(0);" class="dt-tippy-btn" data-bs-toggle="modal" data-bs-target="#view-cover-image-modal-{{$discountBox->id}}" title="@lang('discount_box.view_cover_image')">
        <img src="{{ $discountBox->getFirstMediaUrl('cover_image', 'thumb') }}" alt=""
             style="object-fit: cover; height: 25px; width: 25px" class="rounded-circle" loading="lazy">
    </a>
@else
    <img src="{{ asset('frontend/assets/img/placeholderx1.png') }}"
         alt="{{$discountBox->serial}}"
         class="rounded-circle avatar-md dt-tippy-btn"
         loading="lazy"
         title="@lang('discount_box.no_cover_image')"
         style="object-fit: cover; height: 25px; width: 25px"
    >
@endif
@include('management.discount-boxes._partials.cover-image-modal')
