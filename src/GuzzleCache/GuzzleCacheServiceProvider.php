<?php

namespace Remic\GuzzleCache;

use Illuminate\Support\ServiceProvider;

/**
 * A Laravel 5's package template.
 */
class GuzzleCacheServiceProvider extends ServiceProvider
{
    /**
     * This will be used to register config & view in
     * your package namespace.
     *
     * --> Replace with your package name <--
     */
    protected $packageName = 'guzzlecache';

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Check is performed as this function doesn't exist in Lumen
        if (function_exists('config_path')) {
            $configPath = __DIR__.'/../config/config.php';

            $this->publishes([$configPath => config_path($this->packageName.'.php')], 'config');
        }

        $this->app->singleton('Remic\GuzzleCache\Factory', function ($app) {
            
            $lifetime = config('guzzlecache.lifetime');
            $customStore = config('guzzlecache.custom_store');
            $cachePrefix = config('guzzlecache.cache_prefix');

            if (is_null($customStore) || $customStore == '') {
                // use the default cache store
                return new Factory($app['cache']->store(), $lifetime, $cachePrefix);
            } else {
                // use custom store
                return new Factory($app['cache']->store($customStore), $lifetime, $cachePrefix);
            }
        });

        $this->app->bind('guzzlecache', 'Remic\GuzzleCache\Factory');

        $this->app->make('Remic\GuzzleCache\Factory');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/config.php';
        $this->mergeConfigFrom($configPath, $this->packageName);
    }
}
