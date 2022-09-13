<?php

namespace Infra\Config;

use PDO;

interface DatabaseInterface
{
    public static function getInstance(): PDO;
}