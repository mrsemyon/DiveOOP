<?php

class QueryBuilder
{
    private static $instance = null;
    private static $pdo;

    private function __construct()
    {
        self::$pdo = Connection::getInstance()->pdo();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {

            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function read(string $table, array $where = NULL)
    {
        if ($where) {
            $sql = "SELECT * FROM $table WHERE ";
            foreach ($where as $key => $value) {
                $sql .= $key . '=:' . $key . ' AND ';
            }
            $sql = rtrim($sql, ' AND ') . ';';
            $statement = self::$pdo->prepare($sql);
            $statement->execute($where);
            return $statement->fetch();
        } else {
            $sql = "SELECT * FROM $table";
            $statement = self::$pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll();
        }
    }

    public static function create(string $table, array $data): int
    {
        $keys = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $statement = self::$pdo->prepare($sql);
        $statement->execute($data);
        return self::$pdo->lastInsertId();
    }

    public function update(string $table, $data, $where)
    {
        $sql = "UPDATE $table SET ";
        foreach ($data as $key => $value) {
            $sql .= $key . '= :' . $key . ', ';
        }
        $sql = rtrim($sql, ', ') . ' WHERE ';
        $key = implode(array_keys($where));
        $sql .= $key . '= :' . $key . ';';
        $statement = self::$pdo->prepare($sql);
        $statement->execute(array_merge($data, $where));
    }
}
