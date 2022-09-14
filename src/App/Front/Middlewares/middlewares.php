<?php

use App\Front\Middlewares\Custom\ExemploIda;
use App\Front\Middlewares\Custom\ExemploVolta;
use Infra\Middleware\Layers\Application;
use Infra\Middleware\Layers\Login;
use Infra\Middleware\Layers\MiddlewareCore;
use Infra\Middleware\Layers\Routing;

(MiddlewareCore::getInstance())
    ->add(Login::class)
    ->add(ExemploIda::class)
    ->add(ExemploVolta::class)
    ->add(Application::class)
    ->add(Routing::class);