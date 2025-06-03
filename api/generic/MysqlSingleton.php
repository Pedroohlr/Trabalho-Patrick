<?php

namespace generic;

use PDO;

class MysqlSingleton {
    private static $instance = null;
    private $conexao = null;

    private $dsn     = 'mysql:host=localhost;dbname=seiosf67_curadoria_memes;charset=utf8mb4';
    private $usuario = 'root';
    private $senha   = '';

    private function __construct() {
        try {
            $this->conexao = new PDO(
                $this->dsn,
                $this->usuario,
                $this->senha,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]
            );
        } catch (\PDOException $e) {
            throw new \Exception("Falha na conexão com o banco: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new MysqlSingleton();
        }
        return self::$instance;
    }

    public function executar(string $query, array $param = []) {
        $sth = $this->conexao->prepare($query);
        foreach ($param as $placeholder => $valor) {
            $sth->bindValue($placeholder, $valor);
        }
        $executou = $sth->execute();

        $prefix = strtoupper(substr(trim($query), 0, 6));
        if ($prefix === 'SELECT') {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($prefix === 'INSERT') {
            return (int) $this->conexao->lastInsertId();
        }

        // UPDATE ou DELETE
        return $sth->rowCount();
    }

    public function getConnection(): PDO {
        return $this->conexao;
    }
}
