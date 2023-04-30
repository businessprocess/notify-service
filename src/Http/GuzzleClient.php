<?php

namespace NotificationChannels\Http;

use GuzzleHttp\RequestOptions;
use NotificationChannels\Contracts\Cache;
use NotificationChannels\Contracts\HttpClient;

class GuzzleClient extends BaseClient implements HttpClient
{
    private \GuzzleHttp\Client $http;

    public function __construct(protected Cache $cache, array $config = [])
    {
        $this->processOptions($config);

        $this->http = new \GuzzleHttp\Client([
            'base_uri' => $this->config['url'],
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                RequestOptions::CONNECT_TIMEOUT => $config['connect_timeout'] ?? 80,
                RequestOptions::TIMEOUT => $config['timeout'] ?? 30,
                'http_errors' => true,
            ],
        ]);

        $this->authenticate();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authenticate(): void
    {
        if (isset($this->config['login']) && isset($this->config['password'])) {
            $this->config['authentication'] = $this->auth()->getAuthToken();
        }

        if (! isset($this->config['authentication'])) {
            throw new \InvalidArgumentException('Authentication is required');
        }
    }

    protected function login(): array
    {
        $response = $this->getHttp()->post('login', [
            RequestOptions::JSON => [
                'login' => $this->config['login'],
                'password' => $this->config['password'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getHttp(): \GuzzleHttp\Client
    {
        return $this->http;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $options = []): ?array
    {
        $response = $this->getHttp()->post($uri, [
            RequestOptions::HEADERS => $this->getHeaders(),
            RequestOptions::JSON => $this->prepare($options),
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $options = []): ?array
    {
        $response = $this->getHttp()->get($uri, [
            RequestOptions::HEADERS => $this->getHeaders(),
            RequestOptions::QUERY => $this->prepare($options),
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function getHeaders(): array
    {
        return [
            'Authorization' => $this->config['authentication'],
            'API-KEY' => $this->config['authentication'],
        ];
    }
}
