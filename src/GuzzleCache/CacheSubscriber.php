<?php 

namespace Remic\GuzzleCache;

use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Stream\Stream;
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

        if($request->getMethod() == 'GET' && $this->lifetime)
        {
            $response_key = $this->getCacheResponseKey($request->getUrl());
            $body_key = $this->getCacheBodyKey($request->getUrl());

            if($this->cache->has($response_key) && $this->cache->has($body_key))
            {
                $response = $this->cache->get($response_key);
                $body = $this->cache->get($body_key);
                $response->setBody(Stream::factory($body));
                
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
        $response = $event->getResponse();

        if($request->getMethod() == 'GET' && $response->getStatusCode() == 200 && $this->lifetime)
        {
            $response_key = $this->getCacheResponseKey($request->getUrl());
            $body_key = $this->getCacheBodyKey($request->getUrl());

            if(! $this->cache->has($response_key) || ! $this->cache->has($body_key))
            {
                $body = (string) $response->getBody();
                $this->cache->put($response_key, $response, $this->lifetime);
                $this->cache->put($body_key, $body, $this->lifetime);
            }
        }
    }

    protected function getCacheResponseKey($url)
    {
        return $this->cachePrefix.$url;
    }

    protected function getCacheBodyKey($url)
    {
        return 'guzzle_body_'.$url;
    }
}
