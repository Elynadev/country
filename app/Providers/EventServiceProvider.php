<?php
namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ContactCreatedEvent;
use App\Events\ContactUpdatedEvent;
use App\Events\ContactDeletedEvent;
use App\Listeners\SendContactCreatedNotification;
use App\Listeners\SendContactUpdatedNotification;
use App\Listeners\SendContactDeletedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ContactCreatedEvent::class => [
            SendContactCreatedNotification::class,
        ],
        ContactUpdatedEvent::class => [
            SendContactUpdatedNotification::class,
        ],
        ContactDeletedEvent::class => [
            SendContactDeletedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
