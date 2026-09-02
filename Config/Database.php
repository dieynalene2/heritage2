<?php

namespace App\Database;

abstract class Database
{
    private static ?\PDO $instance = null;

    protected static function getConnexion(): \PDO
    {
        if (self::$instance === null) {
            try {
                $db = 'pgsql:host=localhost;port=5432;dbname=copienote';
                self::$instance = new \PDO($db, 'postgre', '1234', [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                ]);
            } catch (\PDOException $e) {
                throw new \Exception('Erreur de connexion à la base de donnée : ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    protected function query(string $sql, bool $bool = true): mixed
    {
        $pdo = static::getConnexion();
        $query = $pdo->query($sql);

        return $bool ? $query->fetch(\PDO::FETCH_OBJ) : $query->fetchAll(\PDO::FETCH_OBJ);
    }

    protected function prepare(string $sql, array $data = []): \PDOStatement
    {
        $pdo = static::getConnexion();
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
        $pdo = static::getConnexion();
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