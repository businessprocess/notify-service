<?php

namespace NotificationChannels\Models\NotifyService;

use NotificationChannels\Models\NotifyService\Objects\DataObject;

class Data
{
    protected array $items = [];

    /**
     * @param  array  $data
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

    public function fill(array $data = []): static
    {
        if ($this->isList($data)) {
            foreach ($data as $type => $value) {
                $this->add($value, $type);
            }
        } elseif (! empty($data)) {
            $this->add($data);
        }

        return $this;
    }

    private function isList($array): bool
    {
        foreach ($array as $item) {
            return is_array($item);
        }

        return false;
    }

    public function add(DataObject|array $params = [], ?string $type = null): DataObject
    {
        $object = is_array($params) ? new DataObject($params) : $params;

        if (! is_null($object)) {
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

    /**
     * @return array<DataObject>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
