<?php

namespace dao\mysql;

use generic\MysqlFactory;

class VotoDAO extends MysqlFactory {
    public function __construct() {
        parent::__construct();
    }

    public function listarTodos(?int $meme_id = null): array {
        if ($meme_id !== null) {
            $sql = "SELECT id, meme_id, tipo, criado_em 
                    FROM votos 
                    WHERE meme_id = :meme_id 
                    ORDER BY criado_em DESC";
            return $this->banco->executar($sql, [':meme_id' => $meme_id]);
        }

        $sql = "SELECT id, meme_id, tipo, criado_em 
                FROM votos 
                ORDER BY criado_em DESC";
        return $this->banco->executar($sql);
    }

    public function inserir(int $meme_id, string $tipo): int {
        $sql = "INSERT INTO votos (meme_id, tipo) VALUES (:meme_id, :tipo)";
        return $this->banco->executar($sql, [
            ':meme_id' => $meme_id,
            ':tipo'    => $tipo
        ]);
    }
}
