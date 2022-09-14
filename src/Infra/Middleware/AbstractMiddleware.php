<?php

namespace Infra\Middleware;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractMiddleware
{
    protected ?AbstractMiddleware $next = null;

    public function __construct(protected ?ContainerInterface $container = null)
    {
    }

    public function add(AbstractMiddleware $nextMiddleware): AbstractMiddleware
    {
        $this->next = $nextMiddleware;
        return $nextMiddleware;
    }

    abstract public function handle(Request $request): Response;
}