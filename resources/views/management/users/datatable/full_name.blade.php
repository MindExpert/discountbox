@can('view', $user)
    <a href="{{ route('management.users.show', ['user' => $user->id]) }}" class="link-blue">{{ $user->full_name }}</a>
@else
    {{ $user->full_name }}
@endcan
