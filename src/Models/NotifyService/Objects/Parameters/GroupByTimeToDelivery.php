<?php

namespace NotificationChannels\Models\NotifyService\Objects\Parameters;

class GroupByTimeToDelivery extends Parameter
{
    protected ?string $timeToDelivery = null;

    public function setTimeToDelivery(?string $timeToDelivery): GroupByTimeToDelivery
    {
        $this->timeToDelivery = $timeToDelivery;

        return $this;
    }

    public function getTimeToDelivery(): ?string
    {
        return $this->timeToDelivery;
    }
}
