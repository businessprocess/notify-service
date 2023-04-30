<?php

namespace NotificationChannels\Facades;

use Illuminate\Support\Facades\Facade;
use NotificationChannels\Services\NotifyService;

class Notify extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return NotifyService::class;
    }
}
