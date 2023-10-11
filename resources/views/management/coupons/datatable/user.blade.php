@can('view', $coupon->user)
    <a href="{{ route('management.users.show', ['user' => $coupon->user->id]) }}" class="link-blue">{{ $coupon->user->label }}</a>
@else
    {{ $coupon->user?->label }}
@endcan
