<?php

namespace NotificationChannels\Models\NotifyService\Handbook;

use NotificationChannels\Models\NotifyService\Data;
use NotificationChannels\Models\NotifyService\Options;
use NotificationChannels\Models\NotifyService\Traits\Fillable;

class Notification
{
    use Fillable;

    public const STATUS_PENDING = 'pending';

    public const STATUS_SENDED = 'sended';

    public const STATUS_SENDING_ERROR = 'sendingError';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_SENDED,
        self::STATUS_SENDING_ERROR,
    ];

    protected int $id;

    protected string $createdAt;

    protected string $status;

    protected ?string $emitter = null;

    protected ?string $key = null;

    protected ?string $langCode = null;

    protected Data $data;

    protected ?string $text = null;

    protected DeliveryProfile $deliveryProfile;

    protected Template $notifTemplate;

    protected array $notifToDestinations = [];

    protected Options $options;

    protected ?string $timeToDelivery = null;

    public function __construct(array $data = [])
    {
        $this->data = new Data;
        $this->options = new Options;

        $this->fill($data);
    }

    public function isSend(): bool
    {
        return $this->getStatus() === self::STATUS_SENDED;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getEmitter(): ?string
    {
        return $this->emitter;
    }

    public function setEmitter(?string $emitter): void
    {
        $this->emitter = $emitter;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    public function getLangCode(): ?string
    {
        return $this->langCode;
    }

    public function setLangCode(?string $langCode): void
    {
        $this->langCode = $langCode;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getData(): Data
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data->fill($data ?? []);
    }

    public function getDeliveryProfile(): DeliveryProfile
    {
        return $this->deliveryProfile;
    }

    public function setDeliveryProfile($data): void
    {
        $this->deliveryProfile = new DeliveryProfile($data);
    }

    public function getNotifTemplate(): Template
    {
        return $this->notifTemplate;
    }

    public function setNotifTemplate($data): void
    {
        $this->notifTemplate = new Template($data);
    }

    public function getNotifToDestinations(): array
    {
        return $this->notifToDestinations;
    }

    public function setNotifToDestinations(array $notifToDestinations): void
    {
        $this->notifToDestinations = $notifToDestinations;
    }

    public function getOptions(): Options
    {
        return $this->options;
    }

    public function setOptions($options): void
    {
        $options = is_string($options) ? json_decode($options, true) : $options;

        $this->options->fill($options ?? []);
    }

    public function getTimeToDelivery(): ?string
    {
        return $this->timeToDelivery;
    }

    public function setTimeToDelivery(?string $timeToDelivery): void
    {
        $this->timeToDelivery = $timeToDelivery;
    }
}
