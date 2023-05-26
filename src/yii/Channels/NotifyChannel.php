<?php

namespace NotificationChannels\yii\Channels;

use GuzzleHttp\Exception\GuzzleException;
use NotificationChannels\Contracts\HttpClient;
use NotificationChannels\Http\GuzzleClient;
use NotificationChannels\Models\NotifyService\Notice;
use NotificationChannels\yii\Cache\Repository;
use NotificationChannels\yii\Notification;

class NotifyChannel extends \yii\base\BaseObject
{
    private HttpClient $client;

    public function __construct(protected array $config)
    {
        $this->client = new GuzzleClient(new Repository, $config);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @throws GuzzleException
     */
    public function send($notifiable, Notification $notification): void
    {
        /**
         * @var $notice Notice|array
         */
        $notice = call_user_func([$notification, 'toNotify'], compact('notifiable'));

        $params = is_array($notice) ? $notice : $notice->toArray();

        $response = $this->client->post('notifications', $params);

        if (is_object($notice) && method_exists($notice, 'response')) {
            $notice->response($response);
        }
    }
}
