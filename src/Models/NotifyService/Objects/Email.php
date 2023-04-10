<?php

namespace NotificationChannels\Models\NotifyService\Objects;

class Email
{
    protected ?string $from = null;
    protected ?string $subject = null;

    public function toArray(): array
    {
        return array_filter([
            'from' => $this->from,
            'subject' => $this->subject
        ]);
    }

    /**
     * @param string $from
     * @return Email
     */
    public function setFrom(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param string $subject
     * @return Email
     */
    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }
}