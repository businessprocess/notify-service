<?php

namespace NotificationChannels\Http;

abstract class BaseClient
{
    protected array $config;

    /**
     * @param $config
     * @return void
     */
    public function processOptions($config): void
    {
        if (!isset($config['url'])) {
            throw new \InvalidArgumentException('Url is required');
        }

        $this->config = $config;
    }

    public function config($key)
    {
        return $this->config[$key] ?? null;
    }
}