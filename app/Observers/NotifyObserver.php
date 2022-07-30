<?php

namespace App\Observers;
use App\Events\SendNotification;
use App\Models\Contactus;
use App\Models\User;

use App\Notifications\Notify;
use DB;

class NotifyObserver
{
    public function created(Contactus $data)
    {
        $user = User::where('type','Admin')->first();
        $user->notify(new Notify($data));

    }
}
