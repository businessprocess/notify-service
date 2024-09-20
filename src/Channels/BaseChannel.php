<?php

namespace NotificationChannels\Channels;

use Illuminate\Notifications\Notification;
use NotificationChannels\Contracts\HttpClient;

abstract class BaseChannel
{
    public function __construct(protected HttpClient $client) {}

    abstract public function send($notifiable, Notification $notification): void;
}
