#Guzzle Cache Laravel 5 Package

GuzzleCache is a simple wrapper around the [GuzzleHttp](http://docs.guzzlephp.org/en/latest/) library, aimed at optimizing API consuming applications by intercepting **GET** request and storing/retrieving responses from the Laravel's cache engine.

##Installation

Grab the package with composer :

```

    composer require remic/guzzlephp:0.1.*

```

Add this line to your config/app.php providers :

```php

    'Remic\GuzzleCache\GuzzleCacheServiceProvider', 

```

##Usage

Call : 

```php

app('guzzlecache')->client();

```

To get an instances the cache-enabled GuzzleHttp\Client object. Then just use Guzzle the usual way.

Have fun!

##License

MIT