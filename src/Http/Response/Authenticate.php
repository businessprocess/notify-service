<?php

namespace NotificationChannels\Http\Response;

class Authenticate
{
    private string $authToken;

    private string $userUuid;

    public function __construct($params = [])
    {
        $this->authToken = $params['authToken'];
        $this->userUuid = $params['userUuid'];
    }

    public function toArray(): array
    {
        return [
            'authToken' => $this->getAuthToken(),
            'userUuid' => $this->getUserUuid(),
        ];
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getUserUuid(): string
    {
        return $this->userUuid;
    }

    public function __serialize()
    {
        return $this->toArray();
    }

    public function __unserialize(array $values)
    {
        $this->authToken = $values['authToken'];
        $this->userUuid = $values['userUuid'];
    }
}
