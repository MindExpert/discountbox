@can('view', $discountRequest->discount_box)
    <a href="{{ route('management.discount-boxes.show', ['discountBox' => $discountRequest->discount_box->id]) }}" class="link-blue">{{ $discountRequest->discount_box?->label }}</a>
@else
    {{ $discountRequest->discount_box?->label }}
@endcan
