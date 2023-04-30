<?php

namespace NotificationChannels\Models\SmartSender;

class BptPaymentsBot extends AbstractSender
{
    protected string $type = 'bptPaymentsBot';

    public static function task(array $params)
    {
        return new static('api/refill-task', $params);
    }

    public static function history(array $params)
    {
        return new static('api/refill-history', $params);
    }

    public static function status(array $params)
    {
        return new static('api/refill-status', $params);
    }
}
