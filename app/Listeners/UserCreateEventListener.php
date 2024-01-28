<?php

namespace App\Listeners;

use App\Events\UserCreateEvent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Http\Request;
use Illuminate\Support\Str;
use Mail;

class UserCreateEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreateEvent $event): void
    {
        try {
            $request = request();
            DB::transaction(function () use ($request, $event) {

                $name  = $event->name;
                $email = $event->email;
                $role = $event->role;
                $password = $event->password;

                $token    = Str::random(64);
                $formData = ['name' => $name, 'email' => $email, 'password' => $password];

                $link_expires_minute   = 1;
                $url_expiration_minute = now()->addMinutes($link_expires_minute);
                $url                   = \URL::temporarySignedRoute('admin.registration_email_confirmation', $url_expiration_minute, ['token' => $token]);

                Mail::send('auth.mails.register', ['role' => $role, 'password' => $password, 'name' => $name, 'url' => $url], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('New User');
                });

                DB::table('password_reset_tokens')->insert([
                    'email'      => $request->email,
                    'token'      => $token,
                    'created_at' => now(),
                ]);

                $newly_user = User::create($formData)->assignRole($role);
            });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
