<?php

namespace Trov\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Trov\Mail\UserCreated;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        Mail::to($user->email)->send(new UserCreated($user));
    }
}
