<?php

namespace NotificationChannels\Models\NotifyService\Traits;

trait Fillable
{
    public function fill(array $data = []): static
    {
        foreach ($data as $method => $value) {
            $method = 'set'.ucfirst($method);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }

        return $this;
    }
}
