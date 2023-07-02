@can('view', $coupon->assignee)
    <a href="{{ route('management.users.show', ['user' => $coupon->assignee->id]) }}" class="link-blue">{{ $coupon->assignee->full_name }}</a>
@else
    {{ $coupon->assignee?->full_name }}
@endcan
