<?php

namespace NotificationChannels\yii;

use NotificationChannels\Exceptions\NotificationMessengerException;
use Yii;
use yii\base\InvalidParamException;

class Module extends \yii\base\Module
{
    public array $channels = [];

    public function send($notifiable, Notification $notification): void
    {
        foreach ($notification->via($notifiable) as $driver) {
            $channel = $this->getChannel($driver);

            try {
                $channel->send($notifiable, clone $notification);
            } catch (\Exception $e) {
                if (YII_DEBUG) {
                    throw new NotificationMessengerException($e->getMessage());
                }
                Yii::warning("Notification sent by channel [$driver] has failed: " . $e->getMessage(), __METHOD__);
                Yii::warning($e, __METHOD__);
            }
        }
    }

    public function getChannel($driver)
    {
        if (!isset($this->channels[$driver])) {
            throw new InvalidParamException("Unknown channel [{$driver}]");
        }

        if (!is_object($this->channels[$driver])) {
            $this->channels[$driver] = $this->createChannel($this->channels[$driver]);
        }

        return $this->channels[$driver];
    }

    protected function createChannel($config)
    {
        return Yii::createObject($config);
    }
}