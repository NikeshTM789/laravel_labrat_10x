<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserCreateEvent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    function register(Request $request){
        if ($request->isMethod('GET')) {
            return view('auth.register');
        }elseif ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed'
            ]);

            try {
                $password = $request->password;
                $request->merge(['role' => User::USER, 'password' => bcrypt($request)]);
                $user_infos = $request->only(['name', 'email', 'password', 'role']);
                event(new UserCreateEvent(...$user_infos));
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }

            return to_route('admin.login')->withSuccess('An email confirmation link has been sent to your mail.');
        }
    }

    function verifyEmail($token){
        $row = DB::table('password_reset_tokens')->whereToken($token);
        abort_if($row->doesntExist(), 404, 'Token is invalid');

        DB::transaction(function () use($row){
            $email = $row->first()->email;
            User::firstWhere('email',$email)->update(['email_verified_at' => now()]);
            $row->delete();
        });
        return to_route('admin.login')->withSuccess('Email has been successfully verified');

    }
}
