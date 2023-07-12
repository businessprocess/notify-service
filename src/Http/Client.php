<?php

namespace NotificationChannels\Http;

use Illuminate\Cache\Repository;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use NotificationChannels\Contracts\HttpClient;

class Client extends BaseClient implements HttpClient
{
    private PendingRequest $http;

    public function __construct(Factory $factory, protected Repository $cache, array $config = [])
    {
        $this->processOptions($config);

        $this->http = $factory->acceptJson()
            ->baseUrl($this->config['url'])
            ->timeout(30);

        $this->authenticate();
    }

    /**
     * @throws RequestException
     */
    public function authenticate(): void
    {
        if (isset($this->config['login']) && isset($this->config['password'])) {
            $this->config['authentication'] = $this->auth()->getAuthToken();
        }

        if (! isset($this->config['authentication'])) {
            throw new \InvalidArgumentException('Authentication is required');
        }

        $this->http->withHeaders([
            'Authorization' => $this->config['authentication'],
            'API-KEY' => $this->config['authentication'],
        ]);
    }

    /**
     * @throws RequestException
     */
    protected function login(): array
    {
        return $this->getHttp()->post('login', [
            'login' => $this->config['login'],
            'password' => $this->config['password'],
        ])->throw()->json();
    }

    public function getHttp(): Factory|PendingRequest
    {
        return $this->http;
    }

    /**
     * @throws RequestException
     */
    public function post(string $uri, array $options = []): ?array
    {
        $options = $this->prepare($options);

        if (! empty($options['file'])) {

            $options = array_map(function ($value, $key) {
                return $key === 'file' ? $value : [
                    'name' => $key,
                    'contents' => is_array($value) ? json_encode($value) : $value,
                ];
            }, $options, array_keys($options));

            return $this->getHttp()
                ->asMultipart()
                ->post($this->getUrl($uri), $options)
                ->throw()
                ->json();
        }

        return $this->getHttp()->asJson()->post($this->getUrl($uri), $this->prepare($options))->throw()->json();
    }

    /**
     * @throws RequestException
     */
    public function get(string $uri, array $options = []): ?array
    {
        return $this->getHttp()->asJson()->get($this->getUrl($uri), $this->prepare($options))->throw()->json();
    }
}
