<?php

namespace NotificationChannels\Models\NotifyService\Handbook;

use NotificationChannels\Models\NotifyService\Objects\Parameters\DeliveryTimeInterval;
use NotificationChannels\Models\NotifyService\Objects\Parameters\GroupByEmitter;
use NotificationChannels\Models\NotifyService\Objects\Parameters\GroupByPeriod;
use NotificationChannels\Models\NotifyService\Objects\Parameters\GroupByTimeToDelivery;
use NotificationChannels\Models\NotifyService\Traits\Fillable;

class DeliveryProfile
{
    use Fillable;

    protected int $id;

    protected string $uuid;

    protected ?string $parentProfileUuid = null;

    protected ?string $name = null;

    protected ?string $userUuid = null;

    protected ?string $telegramToken = null;

    protected ?bool $doNextDayDelivery = null;

    protected User $user;

    protected GroupByEmitter $groupByEmitter;

    protected GroupByPeriod $groupByPeriod;

    protected GroupByTimeToDelivery $groupByTimeToDelivery;

    protected DeliveryTimeInterval $deliveryTimeInterval;

    /**
     * @var array<Template>
     */
    protected array $notifTemplates = [];

    /**
     * @var array<Notification>
     */
    protected array $notifs = [];

    public function __construct(array $data = [])
    {
        $this->user = new User;
        $this->groupByEmitter = new GroupByEmitter;
        $this->groupByPeriod = new GroupByPeriod;
        $this->groupByTimeToDelivery = new GroupByTimeToDelivery;
        $this->deliveryTimeInterval = new DeliveryTimeInterval;

        $this->fill($data);
    }

    public function getNotifTemplates(): array
    {
        return $this->notifTemplates;
    }

    public function setNotifTemplates(array $notifTemplates): void
    {
        foreach ($notifTemplates as $notifTemplate) {
            $this->notifTemplates[] = new Template($notifTemplate);
        }
    }

    public function getNotifs(): array
    {
        return $this->notifs;
    }

    public function setNotifs(array $notifs): void
    {
        foreach ($notifs as $notif) {
            $this->notifs[] = new Notification($notif);
        }
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser($data): void
    {
        $this->user->fill($data);
    }

    private function prepareParameter($param)
    {
        if (is_bool($param)) {
            return ['enabled' => $param];
        }

        return $param;
    }

    public function getGroupByEmitter(): GroupByEmitter
    {
        return $this->groupByEmitter;
    }

    public function setGroupByEmitter($data): void
    {
        $this->groupByEmitter->fill($this->prepareParameter($data));
    }

    public function getGroupByPeriod(): GroupByPeriod
    {
        return $this->groupByPeriod;
    }

    public function setGroupByPeriod($data): void
    {
        $this->groupByPeriod->fill($this->prepareParameter($data));
    }

    public function getGroupByTimeToDelivery(): GroupByTimeToDelivery
    {
        return $this->groupByTimeToDelivery;
    }

    public function setGroupByTimeToDelivery($data): void
    {
        $this->groupByTimeToDelivery->fill($this->prepareParameter($data));
    }

    public function getDeliveryTimeInterval(): DeliveryTimeInterval
    {
        return $this->deliveryTimeInterval;
    }

    public function setDeliveryTimeInterval($data): void
    {
        $this->deliveryTimeInterval->fill($this->prepareParameter($data));
    }

    public function isDoNextDayDelivery(): ?bool
    {
        return $this->doNextDayDelivery;
    }

    public function setDoNextDayDelivery(bool $doNextDayDelivery): void
    {
        $this->doNextDayDelivery = $doNextDayDelivery;
    }

    public function getTelegramToken(): ?string
    {
        return $this->telegramToken;
    }

    public function setTelegramToken(?string $telegramToken): void
    {
        $this->telegramToken = $telegramToken;
    }

    public function getUserUuid(): ?string
    {
        return $this->userUuid;
    }

    public function setUserUuid(?string $userUuid): void
    {
        $this->userUuid = $userUuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getParentProfileUuid(): ?string
    {
        return $this->parentProfileUuid;
    }

    public function setParentProfileUuid(?string $parentProfileUuid): void
    {
        $this->parentProfileUuid = $parentProfileUuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setGroupByEmitterTimeout($value): void
    {
        $this->groupByEmitter->setTimeoutInMsec($value);
    }

    public function setDeliveryTimeIntervalStart($value): void
    {
        $this->deliveryTimeInterval->setStartTime($value);
    }

    public function setDeliveryTimeIntervalEnd($value): void
    {
        $this->deliveryTimeInterval->setEndTime($value);
    }

    public function setGroupPeriod($value): void
    {
        $this->groupByPeriod->setGroupPeriod($value);
    }

    public function setUseDeliveryTimeInterval(bool $value): void
    {
        $this->deliveryTimeInterval->setEnabled($value);
    }

    public function setDoDeliveryAtTime(bool $value): void
    {
        $this->groupByTimeToDelivery->setEnabled($value);
    }

    public function setTimeToDelivery($value): void
    {
        $this->groupByTimeToDelivery->setTimeToDelivery($value);
    }
}
