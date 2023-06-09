<?php

namespace NotificationChannels\Channels;

use Illuminate\Notifications\Notification;
use NotificationChannels\Exceptions\NotificationMessengerException;

class SmartSenderChannel extends BaseChannel
{
    /**
     * @throws NotificationMessengerException
     */
    public function send($notifiable, Notification $notification): void
    {
        $params = app()->call([$notification, 'toSmartSender'], compact('notifiable'));
        $params = is_array($params) ? $params : $params->toArray();

        try {
            $this->client->post('smartsender/add', $params);
        } catch (\Exception $e) {
            report($e);
            throw new NotificationMessengerException('Smartsender sending error');
        }
    }
}
