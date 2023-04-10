<?php

namespace NotificationChannels\Channels;

use NotificationChannels\Contracts\HttpClient;
use Illuminate\Notifications\Notification;

abstract class BaseChannel
{
    /**
     * @param HttpClient $client
     */
    public function __construct(protected HttpClient $client)
    {
    }

    abstract public function send($notifiable, Notification $notification): void;
}