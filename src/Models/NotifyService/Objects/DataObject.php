<?php

namespace NotificationChannels\Models\NotifyService\Objects;

class DataObject
{
    protected mixed $type;

    protected array $attributes = [];

    public function __construct($data = [])
    {
        $this->attributes = $data;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function setType(mixed $type): DataObject
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
