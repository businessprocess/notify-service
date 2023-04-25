<?php

namespace NotificationChannels\Models\NotifyService\Objects;

class Email
{
    protected ?string $from = null;
    protected ?string $subject = null;
    protected bool|null $isHtml = null;

    public function fill($data): static
    {
        foreach ($data as $method => $value) {
            $method = 'set' . ucfirst($method);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'from' => $this->from,
            'subject' => $this->subject,
            'isHtml' => $this->isHtml,
        ]);
    }

    /**
     * @param string|null $from
     * @return Email
     */
    public function setFrom(?string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param string|null $subject
     * @return Email
     */
    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param bool|null $isHtml
     * @return Email
     */
    public function setIsHtml(?bool $isHtml = null): static
    {
        $this->isHtml = $isHtml;

        return $this;
    }
}