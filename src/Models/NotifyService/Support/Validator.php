<?php

namespace NotificationChannels\Models\NotifyService\Support;

class Validator
{
    public function isEmail($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function isPhone($value): bool
    {
        return is_string($value);
    }

    public function isViber($value): bool
    {
        return $this->isPhone($value);
    }

    public function isTelegram($value): bool
    {
        return is_numeric($value);
    }

    public function isFirebaseToken($value): bool
    {
        return is_string($value);
    }

    public function isWhatsApp($value): bool
    {
        return $this->isPhone($value);
    }

    public function isSms($value): bool
    {
        return $this->isPhone($value);
    }

    public function __call(string $name, array $arguments)
    {
        return ! empty($arguments[0]) && is_string($arguments[0]);
    }
}
