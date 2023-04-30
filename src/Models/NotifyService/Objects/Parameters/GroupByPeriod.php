<?php

namespace NotificationChannels\Models\NotifyService\Objects\Parameters;

class GroupByPeriod extends Parameter
{
    protected ?string $groupPeriod = null;

    public function setGroupPeriod(?string $groupPeriod): GroupByPeriod
    {
        $this->groupPeriod = $groupPeriod;

        return $this;
    }

    public function getGroupPeriod(): ?string
    {
        return $this->groupPeriod;
    }
}
