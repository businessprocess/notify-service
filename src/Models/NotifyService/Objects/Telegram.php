<?php

namespace NotificationChannels\Models\NotifyService\Objects;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

class Telegram
{
    use Fillable;

    protected ?string $token = null;

    public function toArray(): array
    {
        return array_filter([
            'token' => $this->token,
        ]);
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }
}
