#Guzzle Cache Laravel 5 Package

GuzzleCache is a simple wrapper around the [GuzzleHttp](http://docs.guzzlephp.org/en/latest/) library, aimed at optimizing API consuming applications by intercepting **GET** request and storing/retrieving responses from the Laravel's cache engine.

##Installation

Grab the package with composer :

```

    composer require remic/guzzlephp:0.1.*

```

Add these aliases to your config/app.php :

```php

    'Guzzle'        => 'Remic\GuzzleCache\Facades\Guzzle', 
    'GuzzleCache'   => 'Remic\GuzzleCache\Facades\GuzzleCache',

```

Add this line to your config/app.php providers :

```php

    'Remic\GuzzleCache\GuzzleCacheServiceProvider', 

```
Then publish the configuration file :

```

    artisan vendor:publish
    
```


##Usage (No Caching)

From your L5 application, call: 

```php

$client = Guzzle::client(['base_url' => 'http://httpbin.org']);

```

This will return an instance of the GuzzleHttp\Client object wihtout caching. Then use Guzzle the usual way.

##Usage (With Caching)

From your L5 application, call: 

```php

$client = GuzzleCache::client(['base_url' => 'http://httpbin.org']);

```

This will return an instances of the cache-enabled GuzzleHttp\Client object. Then use Guzzle the usual way.

###Specifying a custom lifetime

You can specify an optionnal lifetime when requesting a Guzzle client, that will override the defaults set in GuzzleCache config, for all request made with the object :

```php

// Store all the request made with $client for 15 minutes
$client = app('guzzlecache')->client(['base_url' => 'http://httpbin.org'], 15); 

```

##License

MIT
