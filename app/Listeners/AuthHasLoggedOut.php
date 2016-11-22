<?php

namespace App\Listeners;

use App\Events\auth.logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthHasLoggedOut
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  auth.logout  $event
     * @return void
     */
    public function handle(auth.logout $event)
    {
dump(auth());
dump(request());
    }
}
