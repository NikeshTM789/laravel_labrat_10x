<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('auth.forgot_password.reset_form');
        } elseif ($request->isMethod('POST')) {
            $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
            ]);

            DB::transaction(function () use ($request) {
                $token = str()->random(64);

                DB::table('password_reset_tokens')->where('email', $request->email)->delete();

                DB::table('password_reset_tokens')->insert([
                    'email'      => $request->email,
                    'token'      => $token,
                    'created_at' => now(),
                ]);

                $link_expires_minute   = 1;
                $url_expiration_minute = now()->addMinutes($link_expires_minute);
                $url                   = \URL::temporarySignedRoute('admin.token-verify', $url_expiration_minute, ['token' => $token]);

                Mail::send('auth.mails.password_reset', ['url' => $url, 'link_expires_in' => $link_expires_minute . ' minute'], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });
            });

            return back()->withSuccess('A link has been successfully sent to your email');}
    }

    public function tokenVerify(Request $request, $token)
    {
        if (!$request->hasValidSignature()) {
            return view('auth.forgot_password.reset_form')->withErrors('Link has been expired');
        }
        if (DB::table('password_reset_tokens')->where('token', $token)->doesntExist()) {
            return to_route('admin.forgot_password')->withErrors('Token is invalid');
        }
        return view('auth.forgot_password.new_password', compact('token'));
    }

    public function newPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $password_reset_token = DB::table('password_reset_tokens')->where('token', $request->token);
        if ($password_reset_token->doesntExist()) {
            return to_route('admin.forgot-password')->withErrors('Token is invalid');
        }

        $user_email           = User::whereEmail($password_reset_token->first()->email);
        if ($user_email->doesntExist()) {
            return to_route('admin.forgot-password')->withErrors('Token email is invalid');
        }

        DB::transaction(function () use ($password_reset_token, $user_email, $request) {
            $password_reset_token->delete();
            $user_email->first()->update([
                'password' => bcrypt($request->password),
            ]);
        });
        return to_route('admin.login')->withSuccess('Password successfully updated');
    }
}
