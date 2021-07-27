<?php

namespace Fligno\SesBounce;

use Illuminate\Support\ServiceProvider;
use Fligno\SesBounce\Providers\RouteServiceProvider;
use Fligno\SesBounce\Providers\EmailEventServiceProvider;

class SesBounceServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'SesBounce');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        //Load the views
        $this->publishes([
            __DIR__.'/resources/js' => resource_path('/js')

            ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EmailEventServiceProvider::class);
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
}
