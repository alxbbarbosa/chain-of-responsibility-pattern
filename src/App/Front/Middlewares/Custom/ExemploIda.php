<?php

namespace App\Front\Middlewares\Custom;

use Infra\Middleware\AbstractMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExemploIda extends AbstractMiddleware
{

    public function handle(Request $request): Response
    {
        /** @todo something before passing the responsibility to the next handler */

        return $this->next->handle($request);
    }
}