<?php namespace Remic\GuzzleCache;

use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\CompleteEvent;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Application lavel cache for Guzzle GET Request
 */
class CacheSubscriber implements SubscriberInterface
{
    protected $cache;

    protected $cachePrefix;

    protected $lifetime;

    protected $intercepted = false;

    public function __construct(Cache $cache, $lifetime, $cachePrefix)
    {
        $this->cache = $cache;
        $this->lifetime = $lifetime;
        $this->cachePrefix = $cachePrefix;
    }

    /**
     * Get Events listened by this subscriber
     * 
     * @return array
     */
    public function getEvents()
    {
        return [
            // Provide name and optional priority
            'before'   => ['onBefore'],
            'complete' => ['onComplete'],
            // You can pass a list of listeners with different priorities
            //'error'    => [['beforeError', 'first'], ['afterError', 'last']]
        ];
    }

    /**
     * Intercept any request if cached
     * 
     * @param  BeforeEvent $event [description]
     * @param  [type]      $name  [description]
     * @return void
     */
    public function onBefore(BeforeEvent $event, $name)
    {
        $request = $event->getRequest();
        
        if($request->getMethod() == 'GET')
        {
            $key = $this->getCacheKey($request->getUrl());

            if($this->cache->has($key) )
            {
                $response = $this->cache->get($key);
                
                $event->intercept($response);
              
            }
        }
    }

    /**
     * Store completed request in the cache
     * 
     * @param  CompleteEvent $event 
     * @param  [type]        $name  [description]
     * @return void
     */
    public function onComplete(CompleteEvent $event, $name)
    {
        $request = $event->getRequest();
        
        if($request->getMethod() == 'GET')
        {
            $key = $this->getCacheKey($request->getUrl());
            
            if(! $this->cache->has($key))
            {
                $this->cache->put($key, $event->getResponse(), $this->lifetime);
            }
        }
    }

    protected function getCacheKey($url)
    {
        return $this->cachePrefix.$url;
    }
}
