<?php

use App\ConsoleApplication;

require_once __DIR__ . '/bootstrap.php';

system('clear');
$app = $container->get('console-app');

/** @var ConsoleApplication $app */
$app->main();