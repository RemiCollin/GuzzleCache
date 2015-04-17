<?php namespace RemiCollin\GuzzleCache\Facades;

use Illuminate\Support\Facades\Facade;

class GuzzleCache extends Facade
{

    protected static function getFacadeAccessor()
    {

    	$client = app('laraguzzle');

        return $client;
        
    }

}
