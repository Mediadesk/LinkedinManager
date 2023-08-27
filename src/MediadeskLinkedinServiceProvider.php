<?php


namespace Mediadesk\LinkedinManager;

use Illuminate\Support\ServiceProvider;

class MediadeskLinkedinServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__.'/config/mediadesk-linkedin.php' => config_path('mediadesk-linkedin.php')], 'mediadesk-linkedin');
    }

    public function register()
    {
        $this->app->singleton('LinkedinAgent', function(string $client_id){
            return new LinkedinAgent($client_id);
        });
    }
}