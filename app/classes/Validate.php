<?php

class Validate
{
    private $db = null;

    public function __construct()
    {
        $this->db = Connection::getInstance()->pdo();
    }
}
