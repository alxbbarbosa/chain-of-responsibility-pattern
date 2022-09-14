<?php

namespace Infra\Config;

use PDO;

class Database implements DatabaseInterface
{
    private static ?PDO $pdoConnection = null;
    
    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (! self::$pdoConnection) {
            $diretorio = __DIR__ . '/../Database/database.sqlite';
            self::$pdoConnection = new PDO("sqlite:$diretorio");
            self::$pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$pdoConnection;
    }
}