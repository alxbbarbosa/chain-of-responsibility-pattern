<?php

namespace Infra\Middleware\Layers;

use Infra\Middleware\AbstractMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultLayer extends AbstractMiddleware
{

    public function handle(Request $request): Response
    {

        return $this->next->handle($request);
    }
}