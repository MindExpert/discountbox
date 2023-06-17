@if(session()->has(\App\Support\FlashNotification::SESSION_NAME))
    <script>
        $(document).ready(function () {
            @foreach(session()->get(\App\Support\FlashNotification::SESSION_NAME) as $notification)
                toastr.{{ @$notification['type'] }}('{{ @$notification['message'] }}', '{{ @$notification['title'] }}');
            @endforeach
        })
    </script>
@endif
