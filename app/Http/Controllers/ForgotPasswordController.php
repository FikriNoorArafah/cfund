<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\ForgotPasswordRequest;
use Mailjet\LaravelMailjet\Facades\Mailjet;
use \Mailjet\Resources;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email not found'
            ]);
        }

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created at' => now()
        ]);

        //email body
        $mj = Mailjet::getClient();
        $body = [
            'FromEmail' => env('MAIL_FROM_ADDRESS'),
            'FromName' => env('MAIL_FROM_NAME'),
            'Subject' => 'Reset Password',
            'Text-part' => "Click the following link to reset your password: " . route('password.reset', $token),
            'Html-part' => "Click the following link to reset your password: <a href='" . route('password.reset', $token) . "'>Reset Password</a>",
            'Recipients' => [
                [
                    'Email' => $user->email,
                    'Name' => $user->name
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if ($response->success()) {
            return back()->with('status', 'Reset link has been sent to your email!');
        } else {
            return back()->withErrors(['email' => 'Error sending email']);
        }
    }
}
