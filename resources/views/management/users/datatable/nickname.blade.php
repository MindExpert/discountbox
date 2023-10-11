@can('view', $user)
    <a href="{{ route('management.users.show', ['user' => $user->id]) }}" class="link-blue">
        {{ $user->nickname }}
    </a>
@else
    {{ $user->nickname }}
@endcan
