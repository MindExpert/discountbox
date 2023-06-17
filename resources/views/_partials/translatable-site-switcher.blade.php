<div class="dropdown">
    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    {{ Config::get('languages')[App::getLocale()] }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        @foreach (Config::get('languages') as $lang => $language)
            @if ($lang != App::getLocale())
                    <li><a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a></li>
            @endif
        @endforeach
    </ul>
</div>