<?php

namespace App\Front\Middlewares\Custom;

use Infra\Middleware\AbstractMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExemploVolta extends AbstractMiddleware
{

    public function handle(Request $request): Response
    {
        $response = $this->next->handle($request);

        /**
         * @todo something after getting a response back from the "next handler" and before providing a response object
         */

        return $response;
    }
}