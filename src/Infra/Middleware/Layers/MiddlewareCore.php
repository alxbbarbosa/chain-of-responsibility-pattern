<?php

namespace Infra\Middleware\Layers;

use Symfony\Component\DependencyInjection\ContainerInterface;

class MiddlewareCore
{
    private static ContainerInterface $container;
    private static null|MiddlewareHandler $stackMiddleware = null;

    private function __construct()
    {
    }

    public static function getContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    public static function getInstance(): MiddlewareHandler
    {
        if (empty(self::$stackMiddleware)) {
            self::$stackMiddleware = new MiddlewareHandler(self::$container);
        }

        return self::$stackMiddleware;
    }

    public static function add(string $middleware): MiddlewareHandler
    {
        return (self::getInstance())->add($middleware);
    }
}