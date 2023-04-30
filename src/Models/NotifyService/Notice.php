<?php

namespace NotificationChannels\Models\NotifyService;

use DateTimeInterface;
use NotificationChannels\Models\NotifyService\Traits\Fillable;

class Notice
{
    use Fillable;

    protected string $profileUuid;

    protected string $langCode;

    protected Destination $destination;

    protected Data $data;

    protected Options $options;

    protected ?string $text = null;

    protected ?DateTimeInterface $timeToDelivery = null;

    protected ?string $key = null;

    protected ?string $emitter = null;

    public function __construct($profileUuid = null)
    {
        if (! is_null($profileUuid)) {
            $this->setProfileUuid($profileUuid);
        }
        $this->destination = new Destination();
        $this->options = new Options();
        $this->data = new Data();
    }

    public static function create($data = []): static
    {
        return (new static())->fill($data);
    }

    public function toArray(): array
    {
        return [
            'profileUuid' => $this->getProfileUuid(),
            'langCode' => $this->getLangCode(),
            'destination' => $this->getDestination(),
            'data' => $this->getData(),
            'text' => $this->getText(),
            'options' => $this->getOptions(),
            'timeToDelivery' => $this->getTimeToDelivery(),
            'key' => $this->getKey(),
            'emitter' => $this->getEmitter(),
        ];
    }

    public function __toArray(): array
    {
        return $this->toArray();
    }

    public function setDestination(array $data = []): void
    {
        $this->destination->fill($data);
    }

    public function setData(array $data = []): void
    {
        $this->data->fill($data);
    }

    public function setOptions(array $data = []): void
    {
        $this->options->fill($data);
    }

    public function data(): Data
    {
        return $this->data;
    }

    protected function getData(): ?array
    {
        if ($this->data->isEmpty() && ! $this->getText()) {
            throw new \InvalidArgumentException('Text or data is required');
        }

        if (! $this->data->isEmpty() && $this->getText()) {
            throw new \LogicException('Text cannot be used together data');
        }

        return $this->getText() ? null : $this->data->toArray();
    }

    protected function getText(): ?string
    {
        return $this->text;
    }

    protected function getProfileUuid(): string
    {
        return $this->profileUuid;
    }

    public function setProfileUuid(string $profileUuid): static
    {
        $this->profileUuid = $profileUuid;

        return $this;
    }

    protected function getEmitter(): ?string
    {
        return $this->emitter;
    }

    public function setEmitter(string $emitter): static
    {
        $this->emitter = $emitter;

        return $this;
    }

    protected function getLangCode(): string
    {
        return $this->langCode;
    }

    public function setLangCode(string $langCode): static
    {
        $this->langCode = $langCode;

        return $this;
    }

    protected function getDestination(): array
    {
        if ($this->destination->isEmpty()) {
            throw new \InvalidArgumentException('Destination is required');
        }

        return $this->destination->toArray();
    }

    public function destination(): Destination
    {
        return $this->destination;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    protected function getOptions(): array
    {
        return $this->options->toArray();
    }

    public function options(): Options
    {
        return $this->options;
    }

    protected function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    protected function getTimeToDelivery(): ?string
    {
        if (is_null($this->timeToDelivery)) {
            return $this->timeToDelivery;
        }

        if ($this->timeToDelivery->getTimestamp() < time()) {
            throw new \InvalidArgumentException('Delivery date cannot be in the past');
        }

        return $this->timeToDelivery->format('Y-m-d H:i:s');
    }

    public function setTimeToDelivery(DateTimeInterface|string $timeToDelivery): static
    {
        try {
            $this->timeToDelivery = is_string($timeToDelivery)
                ? date_create_from_format('Y-m-d H:i:s', $timeToDelivery)
                : $timeToDelivery;
        } catch (\Throwable) {
            throw new \InvalidArgumentException('Required time delivery format [Y-m-d H:i:s]');
        }

        return $this;
    }
}
