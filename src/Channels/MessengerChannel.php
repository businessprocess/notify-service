<?php

namespace NotificationChannels\Channels;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Exceptions\NotificationMessengerException;

class MessengerChannel extends BaseChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @return void
     * @throws GuzzleException
     * @throws NotificationMessengerException
     * @throws \Throwable
     */
    public function send($notifiable, Notification $notification): void
    {
        $to = $this->client->config('user_phone') ?? $notifiable?->routeNotificationFor('messengers');

        throw_unless($to, NotificationMessengerException::class, ['message' => 'Route notification is required']);

        $body = app()->call([$notification, 'toMessenger'], compact('notifiable'));

        try {
            $this->client->post('/receiveMessage', [
                'body' => $body,
                'phone' => $to,
                'project_id' => (int)$this->client->config('project_id'),
                'messenger' => $this->client->config('messenger'),
                'sendAll' => $this->client->config('sendAll'),
                'callback_url' => $this->client->config('callback_url'),
            ]);
        } catch (\Exception $e) {
            report($e);
            throw new NotificationMessengerException('Notification sending error');
        }
    }
}
