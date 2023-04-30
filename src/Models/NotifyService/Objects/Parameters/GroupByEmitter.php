<?php

namespace NotificationChannels\Models\NotifyService\Objects\Parameters;

class GroupByEmitter extends Parameter
{
    protected mixed $timeoutInMsec = null;

    public function setTimeoutInMsec(mixed $timeoutInMsec): GroupByEmitter
    {
        $this->timeoutInMsec = $timeoutInMsec;

        return $this;
    }

    public function getTimeoutInMsec(): mixed
    {
        return $this->timeoutInMsec;
    }
}
