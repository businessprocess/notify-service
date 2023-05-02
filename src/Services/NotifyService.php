<?php

namespace NotificationChannels\Services;

use NotificationChannels\Contracts\HttpClient;
use NotificationChannels\Models\NotifyService\Handbook\DeliveryProfile;
use NotificationChannels\Models\NotifyService\Handbook\Notification;

class NotifyService
{
    public function __construct(protected HttpClient $client, protected $collection = null)
    {
    }

    /**
     * @return object|array<DeliveryProfile>
     */
    public function getDeliveryProfiles(int $pageNum = 1, int $pageSize = 20): array|object
    {
        $response = $this->client->get('delivery-profiles/users/{userUuid}', compact('pageNum', 'pageSize'));

        return $this->toResponse($response['items'], DeliveryProfile::class);
    }

    /**
     * @return object|array<Notification>
     */
    public function notifications(int $pageNum = 1, int $pageSize = 20): array|object
    {
        $response = $this->client->get('notifications', compact('pageNum', 'pageSize'));

        return $this->toResponse($response['items'], Notification::class);
    }

    protected function toResponse($values, $class = null)
    {
        if (! is_null($class) && class_exists($class)) {
            if (is_array($values)) {
                $collection = [];
                foreach ($values as $value) {
                    $collection[] = new $class($value);
                }
                $values = $collection;
            } else {
                $values = new $class($values);
            }
        }

        if (is_array($values) && ! is_null($this->collection) && method_exists($this->collection, 'merge')) {
            return $this->collection->merge($values);
        }

        return $values;
    }
}
