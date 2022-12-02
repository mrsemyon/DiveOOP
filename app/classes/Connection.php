<?php

class Connection
{
    private static $instance = null;
    private static $pdo;

    private function __construct()
    {
        $parameters = "mysql:" .
            "host=" . Config::get('mysql.host') . ";" .
            "dbname=" . Config::get('mysql.dbname') . ";" .
            "charset=" . Config::get('mysql.charset');
        self::$pdo = new PDO(
            $parameters,
            Config::get('mysql.username'),
            Config::get('mysql.password'),
            Config::get('mysql.opt')
        );
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {

            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function pdo()
    {
        return self::$pdo;
    }
}
