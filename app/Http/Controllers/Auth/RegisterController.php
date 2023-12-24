<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserCreateEvent;

class RegisterController extends Controller
{
    function __invoke(Request $request){
        if ($request->isMethod('GET')) {
            return view('auth.register');
        }elseif ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email'
            ]);

            try {
                $user_infos = $request->only(['name','email']);
                event(new UserCreateEvent(...$user_infos));
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }

            return to_route('admin.login')->withSuccess('A Password has been sent to your mail.');
        }
    }
}
