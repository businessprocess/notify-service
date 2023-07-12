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
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
            ],
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

    public function post(string $uri, array $options = []): ?array
    {
        $options = $this->prepare($options);
        $bodyFormat = RequestOptions::JSON;

        if (! empty($options['file'])) {
            $bodyFormat = RequestOptions::MULTIPART;

            $options = array_map(function ($value, $key) {
                return $key === 'file' ? $value : [
                    'name' => $key,
                    'contents' => is_array($value) ? json_encode($value) : $value,
                ];
            }, $options, array_keys($options));
        }

        $response = $this->getHttp()->post($this->getUrl($uri), [
            RequestOptions::HEADERS => $this->getHeaders(),
            $bodyFormat => $options,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $options = []): ?array
    {
        $response = $this->getHttp()->get($this->getUrl($uri), [
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
