<?php

namespace App\Listeners;

use App\Events\UserCreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Http\Request;
use Illuminate\Support\Str;
use Mail;
use App\Models\User;

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
        
                $name = $event->name;
                $email = $event->email;
        
                $password = Str::random(8);
                $token    = Str::random(64);
                $formData = ['name' => $name, 'email' => $email, 'password' => $password];

                Mail::send('auth.mails.register', ['password' => $password, 'token' => $token], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('New User');
                });

                DB::table('password_reset_tokens')->insert([
                    'email'      => $request->email,
                    'token'      => $token,
                    'created_at' => now(),
                ]);

                $newly_user = User::create($formData)->assignRole(User::USER);
                /*if ($request->hasFile('profile')) {
                    $newly_user->saveMedia();
                }*/
            });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
