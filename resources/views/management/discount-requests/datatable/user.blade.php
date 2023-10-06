@can('view', $discountRequest->user)
    <a href="{{ route('management.users.show', ['user' => $discountRequest->user->id]) }}" class="link-blue">{{ $discountRequest->user?->full_name }}</a>
@else
    {{ $discountRequest->user?->full_name }}
@endcan
