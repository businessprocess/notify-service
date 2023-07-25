<?php

namespace NotificationChannels\Http;

use NotificationChannels\Http\Response\Authenticate;

abstract class BaseClient
{
    protected array $config;

    public function processOptions($config): void
    {
        if (! isset($config['url'])) {
            throw new \InvalidArgumentException('Url is required');
        }

        $this->config = $config;
    }

    protected function auth(): Authenticate
    {
        return $this->cache->remember(
            __CLASS__,
            43200,
            fn () => new Authenticate($this->login())
        );
    }

    abstract protected function login();

    public function config($key)
    {
        return $this->config[$key] ?? null;
    }

    public function getUrl($url): string
    {
        return str_contains($url, 'userUuid') ? str_replace('{userUuid}', $this->auth()->getUserUuid(), $url) : $url;
    }

    public function prepare(array $options = []): array
    {
        if (array_key_exists('userUuid', $options) && is_null($options['userUuid'])) {
            $options['userUuid'] = $this->auth()->getUserUuid();
        }

        return $options;
    }
}
