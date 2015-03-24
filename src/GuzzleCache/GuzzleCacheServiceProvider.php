<?php namespace Remic\GuzzleCache;

use Illuminate\Support\ServiceProvider;

/**
 * A Laravel 5's package template.
 */
class GuzzleCacheServiceProvider extends ServiceProvider {

    /**
     * This will be used to register config & view in 
     * your package namespace.
     *
     * --> Replace with your package name <--
     */
    protected $packageName = 'guzzlecache';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {           
        $this->app->bindShared('Remic\GuzzleCache\Factory',function ($app) {
            $lifetime = config('guzzlecache.lifetime');
            $customStore = config('guzzlecache.custom_store');
            $cachePrefix = config('guzzlecache.cache_prefix');

            if(is_null($customStore) || $customStore == '')
            {
                // use the default cache store
                return new Factory($app['cache']->store(), $lifetime, $cachePrefix);
            }
            else
            {
                // use custom store
                return new Factory($app['cache']->store($customStore), $lifetime, $cachePrefix);
            }
        });

        $this->app->bind('guzzlecache', 'Remic\GuzzleCache\Factory');

        $this->app->make('Remic\GuzzleCache\Factory');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path($this->packageName.'.php'),
        ]);

    }

}
