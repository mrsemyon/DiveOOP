<?php

$config = [
    'mysql' => [
        'host'      => '127.0.0.1',
        'name'      => 'dive',
        'user'      => 'root',
        'password'  => 'root',
        'charset'   => 'utf8',
        'opt'       => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ],
    ],
];
