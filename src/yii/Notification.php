<?php

namespace NotificationChannels\yii;

use Yii;
use yii\base\InvalidConfigException;

abstract class Notification extends \yii\base\BaseObject
{
    abstract public function via($notifiable): array;

    public static function create($data = []): static
    {
        return new static($data);
    }

    /**
     * @param  mixed  ...$notifiables
     */
    public function sendTo($notifiables): void
    {
        $module = Yii::$app->getModule('notifications');
        if (is_null($module)) {
            throw new InvalidConfigException('Please set up the module in the web/console settings, see README for instructions');
        }

        $notifiables = is_array($notifiables) ? $notifiables : func_get_args();

        foreach ($notifiables as $notifiable) {
            $module->send($notifiable, $this);
        }
    }
}
