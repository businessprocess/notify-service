<?php

namespace NotificationChannels\Models\SmartSender;

abstract class AbstractSender
{
    protected string $url;

    protected string $method;

    protected array $params;

    protected string $type;

    public function __construct(string $url, array $params, string $method = 'post')
    {
        $this->setUrl($url)
            ->setMethod($method)
            ->setParams($params);
    }

    /**
     * @return $this
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMethod($method): self
    {
        if (! in_array(mb_strtolower($method), ['get', 'post'])) {
            throw new \InvalidArgumentException(sprintf('Not support method [%s]', $method));
        }

        $this->method = $method;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getType(): string
    {
        if (! $this->type) {
            $this->type = mb_strtolower((new \ReflectionClass($this))->getShortName());
        }

        return $this->type;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return $this
     */
    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->getUrl(),
            'method' => $this->getMethod(),
            'params' => $this->getParams(),
            'type' => $this->getType(),
        ];
    }

    public function __toArray(): array
    {
        return $this->toArray();
    }
}
