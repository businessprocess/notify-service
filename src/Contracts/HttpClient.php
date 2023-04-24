<?php

namespace NotificationChannels\Contracts;

interface HttpClient
{
    /**
     * @param string $uri
     * @param array $options
     * @return array|null
     */
    public function post(string $uri, array $options = []): ?array;

    public function config($key);
}