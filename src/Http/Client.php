<?php

namespace NotificationChannels\Http;

use Closure;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use NotificationChannels\Contracts\HttpClient;
use OidcAuth\Service\OidcService;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Client extends BaseClient implements HttpClient
{
    private PendingRequest|Factory $client;

    public function __construct(Factory $factory, protected OidcService $auth, protected array $config = [])
    {
        $this->client = $factory->acceptJson()
            ->baseUrl($this->config['url'])
            ->timeout(30)
            ->withHeaders([
                'Authorization' => $this->auth->serviceToken(),
                'API-KEY' => $this->config('api-key'),
            ]);
    }

    /**
     * @throws RequestException
     */
    public function post(string $uri, array $options = []): ?array
    {
        if (! empty($options['file'])) {

            $options = array_map(function ($value, $key) {
                return $key === 'file' ? $value : [
                    'name' => $key,
                    'contents' => is_array($value) ? json_encode($value) : $value,
                ];
            }, $options, array_keys($options));

            return $this->client
                ->retry(3, 0, $this->reAuthentication())
                ->asMultipart()
                ->post($uri, $options)
                ->throw()
                ->json();
        }

        return $this->client
            ->retry(3, 0, $this->reAuthentication())
            ->asJson()
            ->post($uri, $options)
            ->throw()
            ->json();
    }

    /**
     * @throws RequestException
     */
    public function get(string $uri, array $options = []): ?array
    {
        return $this->client->retry(3, 0, $this->reAuthentication())
            ->asJson()
            ->get($uri, $options)
            ->throw()
            ->json();
    }

    private function reAuthentication(): Closure
    {
        return Closure::fromCallable(function (RequestException $e) {
            if (in_array($e->getCode(), [HttpResponse::HTTP_UNAUTHORIZED, HttpResponse::HTTP_BAD_REQUEST])) {
                $this->client->withOptions([
                    'headers' => [
                        'Authorization' => $this->auth->serviceToken(),
                    ]
                ]);

                return true;
            }

            return false;
        });
    }
}
