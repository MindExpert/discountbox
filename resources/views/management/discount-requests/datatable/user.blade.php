@can('view', $discountRequest->user)
    <a href="{{ route('management.users.show', ['user' => $discountRequest->user->id]) }}" class="link-blue">{{ $discountRequest->user?->label }}</a>
@else
    {{ $discountRequest->user?->label }}
@endcan
