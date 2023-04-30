<?php

namespace NotificationChannels\yii;

use NotificationChannels\Http\GuzzleClient;
use NotificationChannels\Services\NotifyService;
use NotificationChannels\yii\Cache\Repository;
use Yii;

/**
 * @mixin NotifyService
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

    public function __call($name, $arguments)
    {
        return self::getInstance()->{$name}(...$arguments);
    }
}
