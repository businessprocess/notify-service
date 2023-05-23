<?php

namespace NotificationChannels\Models\NotifyService\Handbook;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

class CodeRequest
{
    use Fillable;

    protected int $id;

    protected string $code;

    protected User $user;

    public function __construct($data = [])
    {
        $this->user = new User;
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser($data): void
    {
        $this->user->fill($data);
    }
}
