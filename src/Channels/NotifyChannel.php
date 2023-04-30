<?php

namespace NotificationChannels\Channels;

use Illuminate\Notifications\Notification;
use NotificationChannels\Exceptions\NotificationMessengerException;

class NotifyChannel extends BaseChannel
{
    /**
     * @throws NotificationMessengerException
     */
    public function send($notifiable, Notification $notification): void
    {
        $params = app()->call([$notification, 'toNotify'], compact('notifiable'));
        $params = is_array($params) ? $params : $params->toArray();

        try {
            $this->client->post('notifications', $params);
        } catch (\Exception $e) {
            report($e);
            throw new NotificationMessengerException('NotifyService sending error');
        }
    }
}
