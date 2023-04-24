<?php

namespace NotificationChannels\Http;

use Illuminate\Cache\Repository;
use Illuminate\Http\Client\RequestException;
use NotificationChannels\Contracts\HttpClient;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;

class Client extends BaseClient implements HttpClient
{
    private PendingRequest $http;

    public function __construct(Factory $factory, protected Repository $cache, array $config = [])
    {
        $this->processOptions($config);

        $this->http = $factory->asJson()
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
        if (isset($this->config['login']) && isset($this->config['password'])) {
            $this->config['authentication'] = $this->cache->remember(__CLASS__, 12 * 3600, function () {
                return $this->http->post('login', [
                    'login' => $this->config['login'],
                    'password' => $this->config['password'],
                ])->throw()->json('authToken');
            });
        }

        if (!isset($this->config['authentication'])) {
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
     * @return array|null
     * @throws RequestException
     */
    public function post(string $uri, array $options = []): ?array
    {
        return $this->getHttp()->post($uri, $options)->throw()->json();
    }
}