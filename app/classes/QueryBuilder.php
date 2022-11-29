<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function read(string $table, array $where = NULL)
    {
        if ($where) {
            $sql = "SELECT * FROM $table WHERE ";
            foreach ($where as $key => $value) {
                $sql .= $key . '=:' . $key . ' AND ';
            }
            $sql = rtrim($sql, ' AND ') . ';';
            $statement = $this->pdo->prepare($sql);
            $statement->execute($where);
            return $statement->fetch();
        } else {
            $sql = "SELECT * FROM $table";
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll();
        }
    }

    public function create(string $table, array $data): int
    {
        $keys = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
        return $this->pdo->lastInsertId();
    }
}
