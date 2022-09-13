<?php

namespace Infra\Middleware\Layers;

use Infra\Middleware\AbstractMiddleware;
use Psr\Container\ContainerInterface;

class MiddlewareHandler
{
    private array $collection;

    public function add(string $middleware): self
    {
        $this->collection[] = $middleware;
        return $this;
    }

    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function process(AbstractMiddleware $middleware): AbstractMiddleware
    {
        foreach ($this->collection as $element) {
            $middleware = $middleware->add(new $element($this->container));
        }

        return $middleware;
    }
}