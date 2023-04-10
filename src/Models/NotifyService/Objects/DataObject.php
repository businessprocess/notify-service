<?php

namespace NotificationChannels\Models\NotifyService\Objects;

class DataObject
{
    protected string $type;
    protected array $attributes = [];

    public function __construct($data = [])
    {
        $this->attributes = $data;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $type
     * @return DataObject
     */
    public function setType(string $type): DataObject
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}