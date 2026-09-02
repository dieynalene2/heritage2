<?php

namespace Config;

abstract class PpDatabase
{
    private static ?\PDO $instance = null;

    protected static function getConnection(): \PDO
    {
        

        return self::$instance;
    }

    protected function query(string $sql, bool $bool = true): mixed
    {
        $pdo = static::getConnection();
        $query = $pdo->query($sql);

        return $bool ? $query->fetch(\PDO::FETCH_OBJ) : $query->fetchAll(\PDO::FETCH_OBJ);
    }

    protected function prepare(string $sql, array $data = []): \PDOStatement
    {
        $pdo = static::getConnection();
        $prepare = $pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $type = \PDO::PARAM_STR;

            if (is_int($value)) {
                $type = \PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = \PDO::PARAM_BOOL;
            } elseif ($value === null) {
                $type = \PDO::PARAM_NULL;
            }

            $prepare->bindValue($key, $value, $type);
        }

        $prepare->execute();

        return $prepare;
    }

    protected function executeQuery(string $sql, array $data, bool $bool = true): mixed
    {
        $statement = $this->prepare($sql, $data);

        return $bool ? $statement->fetch() : $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    protected function executeUpdate(string $sql, array $datas): int|string
    {
        $pdo = static::getConnection();
        $statement = $pdo->prepare($sql);

        foreach ($datas as $key => $value) {
            $type = \PDO::PARAM_STR;

            if (is_int($value)) {
                $type = \PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = \PDO::PARAM_BOOL;
            } elseif ($value === null) {
                $type = \PDO::PARAM_NULL;
            }

            $statement->bindValue($key, $value, $type);
        }

        $statement->execute();

        return (str_starts_with(strtoupper(trim($sql)), 'INSERT')) ? (string) $pdo->lastInsertId() : (string) $statement->rowCount();
    }
}