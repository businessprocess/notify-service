<?php

namespace NotificationChannels\Channels;

use Illuminate\Notifications\Notification;
use NotificationChannels\Exceptions\NotificationMessengerException;
use NotificationChannels\Models\NotifyService\Notice;

class NotifyChannel extends BaseChannel
{
    /**
     * @throws NotificationMessengerException
     */
    public function send($notifiable, Notification $notification): void
    {
        /**
         * @var $notice Notice|array
         */
        $notice = app()->call([$notification, 'toNotify'], compact('notifiable'));

        $params = is_array($notice) ? $notice : $notice->toArray();

        try {
            $response = $this->client->post('notifications', $params);

            if (is_object($notice) && method_exists($notice, 'response')) {
                $notice->response($response);
            }
        } catch (\Exception $e) {
            report($e);
            throw new NotificationMessengerException('NotifyService sending error');
        }
    }
}
