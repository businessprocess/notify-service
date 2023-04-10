<?php

namespace NotificationChannels\Models\NotifyService;

use NotificationChannels\Models\NotifyService\Objects\DataObject;

class Data
{
    protected array $items = [];

    /**
     * @param array $data
     *
     * [
     *   "user" => [
     *      "value" => ["Alex"],
     *      "groupType": “list”,
     *      "limit": 10
     *    ],
     *   "count" => [
     *      "value" => 1,
     *      "groupType": “sum”,
     *    ]
     * ]
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function fill(array $data): static
    {
        foreach ($data as $type => $value) {
            $this->add($value, $type);
        }

        return $this;
    }

    public function add(DataObject|array $params = [], ?string $type = null): DataObject
    {
        $object = is_array($params) ? new DataObject($params) : $params;

        if (!is_null($object)) {
            $object->setType($type);
        }

        $this->items[] = $object;

        return $object;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[$item->getType()] = $item->toArray();
        }
        return $items;
    }
}