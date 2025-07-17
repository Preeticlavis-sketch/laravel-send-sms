<?php

namespace Preeti\SmsSender;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        // Publish the config file to the user's Laravel project
        $this->publishes([
    __DIR__.'/../config/sms.php' => config_path('sms.php'),
], 'sms-config');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        // Merge default config
       $this->mergeConfigFrom(
    __DIR__.'/../config/sms.php',
    'sms'
);

        // Bind SmsManager to the container
        $this->app->singleton('sms.sender', function ($app) {
            return new SmsManager();
        });
    }
}
