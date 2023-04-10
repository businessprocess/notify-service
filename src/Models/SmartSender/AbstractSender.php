<?php

namespace NotificationChannels\Models\SmartSender;

abstract class AbstractSender
{
    protected string $url;
    protected string $method;
    protected array $params;
    protected string $type;

    /**
     * @param string $url
     * @param string $method
     * @param array $params
     */
    public function __construct(string $url, array $params, string $method = 'post')
    {
        $this->setUrl($url)
            ->setMethod($method)
            ->setParams($params);
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method): self
    {
        if (!in_array(mb_strtolower($method), ['get', 'post'])) {
            throw new \InvalidArgumentException(sprintf('Not support method [%s]', $method));
        }

        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        if (!$this->type) {
            $this->type = mb_strtolower((new \ReflectionClass($this))->getShortName());
        }
        return $this->type;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'url' => $this->getUrl(),
            'method' => $this->getMethod(),
            'params' => $this->getParams(),
            'type' => $this->getType(),
        ];
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return $this->toArray();
    }
}
