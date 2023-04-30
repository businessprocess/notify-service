<?php

namespace NotificationChannels\Contracts;

interface HttpClient
{
    public function post(string $uri, array $options = []): ?array;

    public function get(string $uri, array $options = []): ?array;

    public function config($key);
}
