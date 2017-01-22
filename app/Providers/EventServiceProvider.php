<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Support\Facades\Event;
=======
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
<<<<<<< HEAD
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
=======
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2

        //
    }
}
