<?php

namespace NotificationChannels\Http;

use NotificationChannels\Contracts\HttpClient;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;

class GuzzleClient extends BaseClient implements HttpClient
{
    private \GuzzleHttp\Client $http;

    public function __construct(array $config = [])
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
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authenticate(): void
    {
        if (isset($config['login']) && isset($config['password'])) {
            $config['authentication'] = $this->getHttp()->post('login', [
                RequestOptions::JSON => [
                    'login' => $this->config['login'],
                    'password' => $this->config['password'],
                ]
            ]);
        }

        if (!isset($config['authentication'])) {
            throw new \InvalidArgumentException('Authentication is required');
        }
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttp(): \GuzzleHttp\Client
    {
        return $this->http;
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $options = []): array
    {
        $response = $this->getHttp()->post($uri, [
            RequestOptions::HEADERS => [
                'Authorization' => $this->config['authentication'],
                'API-KEY' => $this->config['authentication'],
            ],
            RequestOptions::JSON => $options
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}