<?php

namespace NotificationChannels\Models\NotifyService\Objects;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

class Email
{
    use Fillable;

    protected ?string $from = null;

    protected ?string $subject = null;

    protected bool|null $isHtml = null;

    public function toArray(): array
    {
        return array_filter([
            'from' => $this->from,
            'subject' => $this->subject,
            'isHtml' => $this->isHtml,
        ]);
    }

    /**
     * @return Email
     */
    public function setFrom(?string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return Email
     */
    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Email
     */
    public function setIsHtml(?bool $isHtml = null): static
    {
        $this->isHtml = $isHtml;

        return $this;
    }
}
