<?php 

namespace Remic\GuzzleCache;

use Illuminate\Contracts\Cache\Repository as Cache;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Client;

class Factory {

    /**
     * Cache instance
     * 
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Default lifetime 
     * 
     * @var string
     */
    protected $lifetime;

 
    public function __construct(Cache $cache, $lifetime, $cachePrefix)
    {
        $this->cache = $cache;
        
        $this->cachePrefix = $cachePrefix;

        $this->lifetime = $lifetime;
    }

    /**
     * Get the cached guzzle client
     *
     * @param  array $config    guzzle's client config array
     * @param  int   $lifetime  (optional) lifetime in cache for this request.
     * 
     * @return \GuzzleHttp\Guzzle\Client;
     */
    public function client(array $config = array(), $lifetime = null)
    {    
        if(is_null($lifetime))
        {
            $lifetime = $this->lifetime;
        }

        $client = new Client($config);

        $emitter = $client->getEmitter();

        $subscriber = new CacheSubscriber($this->cache, $lifetime, $this->cachePrefix);

        $emitter->attach($subscriber);
        
        return $client;
    }

}
