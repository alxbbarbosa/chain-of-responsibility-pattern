<?php

namespace Infra\Middleware\Layers\Routing;

class Route
{
    private static null|Router $router = null;

    private function __construct()
    {
    }

    public static function getInstance(): Router
    {
        if (is_null(self::$router)) {
            self::$router = new Router();
        }

        return self::$router;
    }

    public static function get(string $pattern, string|callable $callable): Router
    {
        return (self::getInstance())->get($pattern, $callable);
    }

    public static function post(string $pattern, string|callable $callable): Router
    {
        return (self::getInstance())->post($pattern, $callable);
    }

    public static function put(string $pattern, string|callable $callable): Router
    {
        return (self::getInstance())->put($pattern, $callable);
    }

    public static function delete(string $pattern, string|callable $callable): Router
    {
        return (self::getInstance())->delete($pattern, $callable);
    }
}