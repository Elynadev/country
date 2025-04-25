<?php

namespace App\Listeners;

use App\Events\ContactUpdatedEvent;
use App\Notifications\ContactUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendContactUpdatedNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ContactUpdatedEvent  $event
     * @return void
     */
    public function handle(ContactUpdatedEvent $event)
    {
        // Envoyer la notification à l'utilisateur actuellement authentifié
        Auth::user()->notify(new ContactUpdated($event->contact));
    }
}
