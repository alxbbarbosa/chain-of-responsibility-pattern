<?php

use App\ConsoleApplication;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();
require_once __DIR__ . '/config/dependency_injection.php';


