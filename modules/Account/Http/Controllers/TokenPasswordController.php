<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Modules\User\Entities\User;

class TokenPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return Response
     */
    public function token(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        if ($request->wantsJson()) {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return response()->json(['message' => trans('passwords.user')], 400);
            }
            $token = $this->broker()->createToken($user);

            Mail::send('account::password/reset_email_token', ['user' => $user, 'token' => $token], function (Message $message) use ($user) {
                $message->subject(config('app.name') . ' - ' . __('Password Reset Link'));
                $message->to($user->email);
            });

            return response()->json(['message' => trans(Password::RESET_LINK_SENT)], 201);
        }
    }
}
