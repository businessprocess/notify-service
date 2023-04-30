<?php

namespace NotificationChannels\yii\Channels;

use NotificationChannels\Contracts\HttpClient;
use NotificationChannels\Http\GuzzleClient;
use NotificationChannels\yii\Cache\Repository;
use NotificationChannels\yii\Notification;

class NotifyChannel extends \yii\base\BaseObject
{
    private HttpClient $client;

    public function __construct(array $config)
    {
        $this->client = new GuzzleClient(new Repository, $config);
    }

    public function send($notifiable, Notification $notification): void
    {
        $params = call_user_func([$notification, 'toNotify'], compact('notifiable'));
        $params = is_array($params) ? $params : $params->toArray();

        $this->client->post('notifications', $params);
    }
}
