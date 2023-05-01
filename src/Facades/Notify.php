<?php

namespace NotificationChannels\Facades;

use Illuminate\Support\Facades\Facade;
use NotificationChannels\Services\NotifyService;

/**
 * @method static array|object getDeliveryProfiles(int $pageNum = 1, int $pageSize = 20)
 * @method static array|object notifications(int $pageNum = 1, int $pageSize = 20)
 */
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
