<?php

namespace Fligno\SesBounce\Providers;

use Illuminate\Mail\Events\MessageSending;
use Fligno\SesBounce\Listener\ValidateInBounceList;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EmailEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MessageSending::class => [
            ValidateInBounceList::class,
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

        //
    }
}
