<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvitationEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invitation_email' => ['required', 'email'],
        ];
    }
}
