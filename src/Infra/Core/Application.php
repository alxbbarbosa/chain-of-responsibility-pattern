<?php

namespace Infra\Core;

use Infra\Middleware\Layers\DefaultLayer;
use Infra\Middleware\Layers\MiddlewareCore;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    public function __construct(protected readonly ContainerInterface $container)
    {
    }

    public function handle(Request $request): Response
    {
        $middlewares = new DefaultLayer($this->container);
        MiddlewareCore::getInstance()->process($middlewares);

        return $middlewares->handle($request);
    }
}