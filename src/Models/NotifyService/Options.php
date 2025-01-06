<?php

namespace NotificationChannels\Models\NotifyService;

use NotificationChannels\Models\NotifyService\Objects\Email;
use NotificationChannels\Models\NotifyService\Objects\Fcm;
use NotificationChannels\Models\NotifyService\Objects\Telegram;

class Options
{
    protected Email $email;

    private Telegram $telegram;

    private Fcm $fcm;

    public function __construct($data = [])
    {
        $this->email = new Email;
        $this->telegram = new Telegram;
        $this->fcm = new Fcm;
        $this->fill($data);
    }

    public function fill($data): static
    {
        foreach ($data as $method => $value) {
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }

        return $this;
    }

    public function email($subject = null, ?string $from = null, $isHtml = null): Email
    {
        if (is_array($subject)) {
            return $this->email->fill($subject);
        }
        if (! is_null($subject)) {
            $this->email->setSubject($subject);
        }
        if (! is_null($from)) {
            $this->email->setFrom($from);
        }

        $this->email->setIsHtml($isHtml);

        return $this->email;
    }

    public function telegram($token = null): Telegram
    {
        if (! is_null($token)) {
            $this->telegram->setToken($token);
        }

        return $this->telegram;
    }

    public function fcm($data = null): Fcm
    {
        if (! is_null($data)) {
            $this->fcm->setData($data);
        }

        return $this->fcm;
    }

    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email->toArray(),
            'telegram' => $this->telegram->toArray(),
            'fcm' => $this->fcm->toArray(),
        ]);
    }
}
