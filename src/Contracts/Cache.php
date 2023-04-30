<?php

namespace NotificationChannels\Contracts;

use Closure;

interface Cache
{
    public function remember($key, $ttl, Closure $callback);

    public function get($key);

    public function put($key, $value, $ttl);
}
