<?php

namespace Fligno\SesBounce;

use Illuminate\Support\ServiceProvider;
use Fligno\SesBounce\Providers\RouteServiceProvider;
use Fligno\SesBounce\Providers\EmailEventServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

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

        // Load factories
        $this->registerEloquentFactoriesFrom(__DIR__ . '/database/factories');
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
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}
