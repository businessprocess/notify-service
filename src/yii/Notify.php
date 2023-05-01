<?php

namespace NotificationChannels\yii;

use NotificationChannels\Http\GuzzleClient;
use NotificationChannels\Services\NotifyService;
use NotificationChannels\yii\Cache\Repository;
use Yii;

/**
 * @method static array|object getDeliveryProfiles(string $query = '', int $pageNum = 1, int $pageSize = 20, $userUuid = null)
 * @method static array|object notifications(int $pageNum = 1, int $pageSize = 20, $userUuid = null)
 */
class Notify
{
    private static ?NotifyService $instance = null;

    private static function getInstance(): NotifyService
    {
        if (is_null(self::$instance)) {
            $module = Yii::$app->getModule('notifications');

            self::$instance = new NotifyService(new GuzzleClient(new Repository, $module->channels['notify']));
        }
        return self::$instance;
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getInstance()->{$name}(...$arguments);
    }
}