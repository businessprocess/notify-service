<?php

namespace NotificationChannels\Models\NotifyService\Handbook;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

class User
{
    use Fillable;

    protected int $id;

    protected string $uuid;

    protected string $login;

    protected string $password;

    protected string $name;

    protected bool $isVerified;

    /**
     * @var array<CodeRequest>
     */
    protected array $codeRequests = [];

    /**
     * @var array<DeliveryProfile>
     */
    protected array $deliveryProfiles = [];

    protected bool $isAdmin;

    protected ?string $deletedAt = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }

    public function getCodeRequests(): array
    {
        return $this->codeRequests;
    }

    public function setCodeRequests(array $codeRequests): void
    {
        foreach ($codeRequests as $codeRequest) {
            $this->codeRequests[] = new CodeRequest($codeRequest);
        }
    }

    public function getDeliveryProfiles(): array
    {
        return $this->deliveryProfiles;
    }

    public function setDeliveryProfiles(array $deliveryProfiles): void
    {
        foreach ($deliveryProfiles as $deliveryProfile) {
            $this->deliveryProfiles[] = new DeliveryProfile($deliveryProfile);
        }
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?string $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
