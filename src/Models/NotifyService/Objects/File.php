<?php

namespace NotificationChannels\Models\NotifyService\Objects;

use NotificationChannels\Models\NotifyService\Traits\Fillable;

class File
{
    use Fillable;

    protected string $name = 'file';

    protected ?string $path = null;

    protected ?string $filename = null;

    protected array $headers = [];

    public function __construct($data = [])
    {
        $this->fill($data);
    }

    public function toArray(): array
    {
        return ! $this->path ? [] : [
            'name' => $this->getName(),
            'contents' => $this->getContents(),
            'filename' => $this->getFilename(),
            'headers' => $this->getHeaders(),
        ];
    }

    public function setName(string $name): File
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPath(string $path): File
    {
        $this->path = $path;

        return $this;
    }

    public function getContents()
    {
        return fopen($this->path, 'r');
    }

    public function setFilename(?string $filename): File
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename ?? basename($this->path);
    }

    public function setHeaders(array $headers): File
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
