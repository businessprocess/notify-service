<?php

namespace NotificationChannels\Models\NotifyService\Objects\Parameters;

class DeliveryTimeInterval extends Parameter
{
    protected ?string $startTime = null;

    protected ?string $endTime = null;

    public function setStartTime(?string $startTime): DeliveryTimeInterval
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setEndTime(?string $endTime): DeliveryTimeInterval
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }
}
