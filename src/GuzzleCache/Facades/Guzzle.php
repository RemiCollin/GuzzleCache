<?php namespace Remic\GuzzleCache\Facades;

use Illuminate\Support\Facades\Facade;

class Guzzle extends Facade
{

    protected static function getFacadeAccessor()
    {

    	$client = \GuzzleHttp\Client;

        return $client;
        
    }

}
