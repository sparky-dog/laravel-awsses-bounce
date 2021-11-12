<?php

namespace Fligno\SesBounce\Src;

use Illuminate\Support\ServiceProvider;
use Fligno\SesBounce\Src\Providers\RouteServiceProvider;
use Fligno\SesBounce\Src\Providers\EmailEventServiceProvider;

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
            __DIR__.'/resources/js' => resource_path('/js'),
            __DIR__.'/resources/views/gui.blade.php' => resource_path('/views/gui.blade.php'), 
            __DIR__ . '/resources/package.json' => base_path('/package.json'),
            __DIR__ . '/resources/webpack.mix.js' => base_path('/webpack.mix.js'),
            ]
            , 'sesbounce');
        $this->commands([
           
               
                Console\Commands\SesBounceComponent::class
    
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

}
