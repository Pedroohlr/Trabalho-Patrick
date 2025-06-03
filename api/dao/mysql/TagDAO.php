<?php

namespace dao\mysql;

use generic\MysqlFactory;

class TagDAO extends MysqlFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listarTodas(): array
    {
        $sql = "SELECT id, nome FROM tags ORDER BY nome ASC";
        return $this->banco->executar($sql);
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT id, nome FROM tags WHERE id = :id";
        $resultado = $this->banco->executar($sql, [':id' => $id]);

        return count($resultado) > 0 ? $resultado[0] : null;
    }

    public function inserir(string $nome): int
    {
        $sql = "INSERT INTO tags (nome) VALUES (:nome)";
        return $this->banco->executar($sql, [':nome' => $nome]);
    }

    public function atualizar(int $id, string $nome): bool
    {
        $sql = "UPDATE tags SET nome = :nome WHERE id = :id";
        $params = [
            ':nome' => $nome,
            ':id' => $id
        ];
        return $this->banco->executar($sql, $params);
    }

    public function deletar(int $id): bool
    {
        $sqlRelacionamento = "DELETE FROM meme_tag WHERE tag_id = :id";
        $this->banco->executar($sqlRelacionamento, [':id' => $id]);

        $sql = "DELETE FROM tags WHERE id = :id";
        return $this->banco->executar($sql, [':id' => $id]);
    }
}
