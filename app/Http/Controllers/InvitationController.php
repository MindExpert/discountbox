<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationEmailRequest;
use App\Mail\InvitationMail;
use Exception;
use Illuminate\Support\Facades\Mail;

class InvitationController
{
    public function __invoke(InvitationEmailRequest $request)
    {
         try {
             $email = $request->input('invitation_email');

             $data = [
                  'invitation_code'  => auth()->user()->invitation_code,
                  'invitation_email' => $email,
                  'inviter_name'     => auth()->user()->label,
                  'registration_url' => route('register', ['invitation_code' => auth()->user()->invitation_code]),
             ];

             Mail::to($email)->send(new InvitationMail($data));


             return response()->json([
                 'success' => true,
                 'message' => __('user.responses.invitation_sent'),
             ]);
         } catch (Exception $e) {
             report($e);

             return response()->json([
                 'success' => false,
                 'message' => __('user.responses.invitation_not_sent'),
             ]);
         }
    }
}
