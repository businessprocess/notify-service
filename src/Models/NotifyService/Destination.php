<?php

namespace NotificationChannels\Models\NotifyService;

use NotificationChannels\Models\NotifyService\Support\Validator;

/**
 * @method Destination email(...$values)
 * @method Destination phone(...$values)
 * @method Destination viber(...$values)
 * @method Destination telegram(...$values)
 * @method Destination firebaseToken(...$values)
 * @method Destination whatsApp(...$values)
 * @method Destination sms(...$values)
 */
class Destination
{
    public const EMAIL = 'email';

    public const PHONE = 'phone';

    public const VIBER = 'viber';

    public const TELEGRAM = 'telegram';

    public const FIREBASE_TOKEN = 'firebaseToken';

    public const WHATSAPP = 'whatsApp';

    public const SMS = 'sms';

    public const SERVICES = [
        self::EMAIL,
        self::PHONE,
        self::VIBER,
        self::TELEGRAM,
        self::FIREBASE_TOKEN,
        self::WHATSAPP,
        self::SMS,
    ];

    private Validator $validator;

    protected array $services = [];

    public function __construct(array $data = [])
    {
        $this->validator = new Validator;
        $this->fill($data);
    }

    public function fill(array $data): static
    {
        foreach ($data as $key => $value) {
            $this->{$key}($value);
        }

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    public function toArray(): array
    {
        return array_filter($this->services);
    }

    public function __call(string $name, array $arguments)
    {
        if (in_array($name, self::SERVICES)) {
            $this->setValues($name, $arguments);
        }

        return $this;
    }

    private function setValues(string $type, array $values): void
    {
        $keys = [];
        foreach ($this->values(...$values) as $value) {
            if (call_user_func([$this->validator, 'is'.ucfirst($type)], $value)) {
                $keys[] = $value;
            }
        }

        if (! isset($this->services[$type])) {
            $this->services[$type] = [];
        }

        $this->services[$type] = array_unique(array_merge($keys, $this->services[$type]));
    }

    private function values($values): array
    {
        return is_array($values) ? $values : func_get_args();
    }
}
