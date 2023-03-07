<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    use Password;
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('token', 'email'));
    }

    public function reset(ResetPasswordRequest $request)
    {
        $reset_password_status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
                event(new PasswordReset($user));
            }
        );

        if ($reset_password_status == Password::PASSWORD_RESET) {
            // send email notification
            $user = User::where('email', $request->email)->first();
            Mail::send('emails.reset-password-email', ['user' => $user, 'url' => env('APP_URL')], function (Message $message) use ($user) {
                $message->to($user->email);
                $message->subject('Password Reset Confirmation');
            });
            return redirect()->route('login')->with('success', 'Your password has been reset. Please check your email for confirmation.');
        } else {
            return back()->withErrors(['email' => [__($reset_password_status)]]);
        }
    }
}
