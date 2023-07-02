@can('view', $coupon->user)
    <a href="{{ route('management.users.show', ['user' => $coupon->user->id]) }}" class="link-blue">{{ $coupon->user->full_name }}</a>
@else
    {{ $coupon->user?->full_name }}
@endcan
