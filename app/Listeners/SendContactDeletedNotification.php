<?php
namespace App\Listeners;

use App\Events\ContactDeletedEvent;
use App\Notifications\ContactDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendContactDeletedNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ContactDeletedEvent  $event
     * @return void
     */
    public function handle(ContactDeletedEvent $event)
    {
        // Envoyer la notification à l'utilisateur actuellement authentifié
        Auth::user()->notify(new ContactDeleted($event->contact));
    }
}
