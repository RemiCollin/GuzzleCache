#Guzzle Cache Laravel 5 Package

GuzzleCache is a simple wrapper around the [GuzzleHttp](http://docs.guzzlephp.org/en/latest/) library, aimed at optimizing API consuming applications by intercepting **GET** request and storing/retrieving responses from the Laravel's cache engine.

##Installation

Grab the package with composer :

```

    composer require remic/guzzlecache:~0.2

```

##Configuration

The GuzzleCache package works both with Laravel 5 and Lumen, but the configuration process is different. 

###Laravel

In Laravel, you need to register the packages service provider into your config/app.php configuration file :

```php

    Remic\GuzzleCache\GuzzleCacheServiceProvider::class, 

```

If you're using facades, add this line to the corresponding section in config/app.php :

```php

    'GuzzleCache'   => Remic\GuzzleCache\Facades\GuzzleCache::class,

```

GuzzleCache come shipped with a default configuration file, if you wish to override these defaults, you have to publish the configuration file :

```

    artisan vendor:publish
    
```

###Lumen

In Lumen, you need to register the package's service provider into the bootstrap/app.php file :

```php

    $app->register(Remic\GuzzleCache\GuzzleCacheServiceProvider::class);

```

If you wish to use the GuzzleCache facade, first make sure `$app->withFacades();` is uncommented in `bootstrap/app.php`, then add the following class alias :

```php

    class_alias(Remic\GuzzleCache\Facades\GuzzleCache::class,, 'GuzzleCache');

```

In Lumen, the configuration is handled via the .env file at the root of the project. Here are the default values used by GuzzleCache. If you wish to modify these, just copy and paste these to your .env file :

```

GUZZLECACHE_LIFETIME=60
GUZZLECACHE_STORE=
GUZZLECACHE_PREFIX=guzzlecache_

```

##Usage

From your L5 application, call: 

```php

$client = GuzzleCache::client(['base_url' => 'http://httpbin.org']);

$res = $client->request('GET', '/');

echo $res->getStatusCode();

```

This will return an instances of the cache-enabled GuzzleHttp\Client object. Then use Guzzle the usual way.

###Specifying a custom lifetime

You can specify an optionnal lifetime when requesting a Guzzle client, that will override the defaults set in GuzzleCache config, for all request made with the object :

```php

// Store all the request made with $client for 15 minutes
$client = GuzzleCache::client(['base_url' => 'http://httpbin.org'], 15); 

```

##License

MIT
