<?php

namespace NotificationChannels\Models\NotifyService\Objects\Parameters;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

abstract class Parameter
{
    use Fillable;

    protected ?bool $enabled = null;

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function setEnabled(bool $enabled): Parameter
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }
}
