<?php

namespace NotificationChannels\Models\NotifyService\Handbook;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

class Template
{
    use Fillable;

    protected int $id;

    protected string $langCode;

    protected string $text;

    protected DeliveryProfile $deliveryProfile;

    /**
     * @var array<Notification>
     */
    protected array $notifs = [];

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLangCode(): string
    {
        return $this->langCode;
    }

    public function setLangCode(string $langCode): void
    {
        $this->langCode = $langCode;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getDeliveryProfile(): DeliveryProfile
    {
        return $this->deliveryProfile;
    }

    public function setDeliveryProfile($deliveryProfile): void
    {
        $this->deliveryProfile = new DeliveryProfile($deliveryProfile);
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
}
