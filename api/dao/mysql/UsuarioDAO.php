<?php

namespace dao\mysql;

use generic\MysqlFactory;

class UsuarioDAO extends MysqlFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT id, nome, email, senha FROM usuarios WHERE id = :id";
        $resultado = $this->banco->executar($sql, [':id' => $id]);

        return count($resultado) > 0 ? $resultado[0] : null;
    }

    public function inserir(string $nome, string $email, string $senha): int
    {
        $sql = "INSERT INTO usuarios (nome,email,senha) VALUES (:nome, :email, :senha)";
        return $this->banco->executar($sql, [':nome' => $nome, ':email' => $email, ':senha' => $senha]);
    }
}