<?php

namespace NotificationChannels\Models\NotifyService\Objects;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

class Fcm
{
    use Fillable;

    protected array $data = [];

    public function toArray(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
