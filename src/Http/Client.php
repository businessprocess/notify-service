<?php

namespace NotificationChannels\Http;

use Illuminate\Cache\Repository;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use NotificationChannels\Contracts\HttpClient;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;

class Client extends BaseClient implements HttpClient
{
    public function __construct(protected Factory $http, protected Repository $cache, array $config = [])
    {
        $this->processOptions($config);

        $this->http->asJson()
            ->baseUrl($this->config['url'])
            ->connectTimeout(80)
            ->timeout(30);

        $this->authenticate();
    }

    /**
     * @return void
     * @throws RequestException
     */
    public function authenticate(): void
    {
        if (isset($config['login']) && isset($config['password'])) {
            $config['authentication'] = $this->cache->remember(__CLASS__, 12 * 3600, function () {
                return $this->http->post('login', [
                    'login' => $this->config['login'],
                    'password' => $this->config['password'],
                ])->throw()->json('authToken');
            });
        }

        if (!isset($config['authentication'])) {
            throw new \InvalidArgumentException('Authentication is required');
        }

        $this->http->withHeaders([
            'Authorization' => $this->config['authentication'],
            'API-KEY' => $this->config['authentication'],
        ]);
    }

    /**
     * @return Factory|PendingRequest
     */
    public function getHttp(): Factory|PendingRequest
    {
        return $this->http;
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array
     * @throws RequestException
     */
    public function post(string $uri, array $options = []): array
    {
        return $this->getHttp()->post($uri, $options)->throw()->json();
    }
}