<?php
namespace App\Listeners;

use App\Events\ContactCreatedEvent;
use App\Notifications\ContactCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendContactCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ContactCreatedEvent  $event
     * @return void
     */
    public function handle(ContactCreatedEvent $event)
    {
        // Envoyer la notification à l'utilisateur actuellement authentifié
        Auth::user()->notify(new ContactCreated($event->contact));
    }
}
