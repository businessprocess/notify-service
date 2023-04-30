<?php

namespace NotificationChannels\yii\Cache;

use Closure;
use NotificationChannels\Contracts\Cache;
use Yii;
use yii\caching\CacheInterface;

class Repository implements Cache
{
    private CacheInterface $cache;

    public function __construct($cache = null)
    {
        $this->cache = $cache ?? Yii::$app->cache;
    }

    public function remember($key, $ttl, Closure $callback): mixed
    {
        $value = $this->get($key);

        if (! is_null($value)) {
            return $value;
        }

        $value = $callback();

        $this->put($key, $value, $ttl);

        return $value;
    }

    public function get($key): mixed
    {
        return $this->cache->exists($key) ? $this->cache->get($key) : null;
    }

    public function put($key, $value, $ttl): void
    {
        $this->cache->set($key, $value, $ttl);
    }
}
