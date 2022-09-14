<?php

use Infra\Core\Application;
use Infra\Middleware\Layers\MiddlewareCore;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

require_once __DIR__ . '/../vendor/autoload.php';

$session = new Session();
$session->start();

/** @var ContainerInterface $container */
$container = new ContainerBuilder();
require_once __DIR__ . '/../config/dependency_injection.php';

MiddlewareCore::getContainer($container);
require_once __DIR__ . '/../src/App/Front/Middlewares/middlewares.php';

$request = Request::createFromGlobals();
$request->setSession($session);
require_once __DIR__ . '/../src/App/Front/Routing/routes.php';

/** @var Application $app */
$app = $container->get('web-app');
$app->handle($request)->sendHeaders()->sendContent();
