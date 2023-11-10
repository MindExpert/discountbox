<x-mail::message>
# Hi there,

    You have been invited to join {{ config('app.name') }}, from {{ $data['inviter_name'] ?? '' }}.

    Please click the button below to register your account, and use the code sent  below:

    Code: # {{ $data['invitation_code'] ?? '' }}

    If you have any questions, please contact us.

<x-mail::button :url="$data['registration_url']">
@lang('general.actions.register')
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
