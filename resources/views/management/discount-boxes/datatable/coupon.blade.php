@can('view', $discountBox->coupon)
    <a href="{{ route('management.coupons.show', ['coupon' => $discountBox->coupon_id]) }}" class="btn-link">{{ $discountBox->coupon->label }}</a>
@else
    {{ $discountBox->coupon?->label ?? '---' }}
@endcan
