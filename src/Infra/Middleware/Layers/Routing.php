<?php

namespace Infra\Middleware\Layers;

use Infra\Middleware\AbstractMiddleware;
use Infra\Middleware\Layers\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Routing extends AbstractMiddleware
{

    public function handle(Request $request): Response
    {
        return $this->match($request);
    }

    protected function match(Request $request): Response
    {
        $action = (Route::getInstance())->getRouteBy($request->getMethod(), $request->getRequestUri());

        $element = ['Defaults\\PageNotFound', 'action'];
        if ($action) {
            $this->defineSegmentsIn($request);
            $element = explode('::', $action);
        }

        return $this->dispatch($element, $request);
    }

    protected function defineSegmentsIn(Request $request): void
    {
        if ($segments = (Route::getInstance())->getSegments()) {
            $request->query->add($segments);
        }
    }

    protected function dispatch(array $element, Request $request): Response
    {
        $class = 'App\\Front\\Controllers\\' . $element[0];
        $controller = (new $class($this->container));

        return call_user_func_array([$controller, $element[1]], [$request]);
    }
}