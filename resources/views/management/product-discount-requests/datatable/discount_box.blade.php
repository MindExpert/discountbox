@can('view', $productDiscountRequest->discount_box)
    <a href="{{ route('management.discount-boxes.show', ['discountBox' => $productDiscountRequest->discount_box->id]) }}" class="link-blue">{{ $productDiscountRequest->discount_box?->label }}</a>
@else
    {{ $productDiscountRequest->discount_box?->label }}
@endcan
