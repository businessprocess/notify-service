<?php

namespace NotificationChannels\Models\NotifyService;

use NotificationChannels\Models\NotifyService\Objects\Email;

class Options
{
    protected Email $email;

    public function __construct($data = [])
    {
        $this->email = new Email();
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

    public function email($subject = null, ?string $from = null): Email
    {
        if (is_array($subject) && isset($subject['from'], $subject['subject'])) {
            [$from, $subject] = [$subject['from'], $subject['subject']];
        }
        if (!is_null($subject)) {
            $this->email->setSubject($subject);
        }
        if (!is_null($from)) {
            $this->email->setFrom($from);
        }
        return $this->email;
    }

    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email->toArray(),
        ]);
    }
}