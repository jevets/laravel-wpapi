<?php

namespace Jevets\WpApi;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * Register any application services
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->path('config/wpapi.php'), 'wpapi');

        $this->app->singleton(WpApi::class, function ($app) {
            return new WpApi(data_get($app, 'config.wpapi'));
        });

        $this->app->bind('wpapi', function ($app) {
            return $app['Jevets\WpApi\WpApi'];
        });
    }

    /**
     * Publish the config files
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            $this->path('config/wpapi.php') => config_path('wpapi.php'),
        ]);
    }

    /**
     * Get an absolute path to this package
     *
     * @param string $path
     * @return string
     */
    protected function path($path = null)
    {
        return __DIR__ . '/../' . $path;
    }
}
