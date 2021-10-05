<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use Statamic\Events\EntrySaved;
use App\Listeners\UpdateExpirationDates;
use App\Listeners\CreateLocalizedEntry;
use App\Listeners\SendNotificationEmailNewSubmission;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use DoubleThreeDigital\SimpleCommerce\Events\OrderPaid;
use DoubleThreeDigital\GuestEntries\Events\GuestEntryCreated;

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
        OrderPaid::class => [
            UpdateExpirationDates::class,
        ],
        GuestEntryCreated::class => [
            CreateLocalizedEntry::class,
            SendNotificationEmailNewSubmission::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
