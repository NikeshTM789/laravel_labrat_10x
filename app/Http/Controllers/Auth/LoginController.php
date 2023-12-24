<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\{Auth, DB};

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('auth.login');
        } elseif ($request->isMethod('POST')) {

            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]);

            $identifier = 'login_attempt_'.$request->ip();
            if(RateLimiter::tooManyAttempts($identifier, 3/*attempts per minute*/)){
                $seconds = RateLimiter::availableIn($identifier);

                return back()->withErrors(['Too many login attempts. please try again after '.$seconds.' seconds']);
            }

            if (Auth::attempt($credentials, $request->has('remember'))) {
                auth()->user()->update(['email_verified_at' => now()]);

                RateLimiter::clear($identifier);

                return redirect()->intended('admin');
            }

            RateLimiter::hit($identifier, 120/* decay time in seconds*/);

            return back()->withErrors(['credentials' => 'Information does not match']);
        }
    }
}
