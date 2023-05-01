<?php

namespace NotificationChannels\Models\NotifyService\Objects\Parameters;

class GroupByPeriod extends Parameter
{
    public const MINUTE_1 = 'minute1';

    public const MINUTE_5 = 'minute5';

    public const MINUTE_30 = 'minute30';

    public const HOUR_1 = 'hour1';

    public const HOUR_2 = 'hour2';

    public const HOUR_5 = 'hour5';

    public const HOUR_10 = 'hour10';

    public const HOUR_12 = 'hour12';

    public const DAY_1 = 'day1';

    public const DAY_2 = 'day2';

    public const DAY_5 = 'day5';

    public const DAY_10 = 'day10';

    public const DAY_12 = 'day12';

    public const PERIODS = [
        self::MINUTE_1,
        self::MINUTE_5,
        self::MINUTE_30,
        self::HOUR_1,
        self::HOUR_2,
        self::HOUR_5,
        self::HOUR_10,
        self::HOUR_12,
        self::DAY_1,
        self::DAY_2,
        self::DAY_5,
        self::DAY_10,
        self::DAY_12,
    ];

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
