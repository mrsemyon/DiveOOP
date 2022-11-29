<?php

class Connection
{
    public static function make(array $config): PDO
    {
        return new PDO(
            "mysql:host={$config['host']};dbname={$config['name']};charset={$config['charset']}",
            $config['user'],
            $config['password'],
            $config['opt']
        );
    }
}
