<?php

namespace service;

use dao\mysql\VotoDAO;

class VotoService {
    private VotoDAO $dao;

    public function __construct() {
        $this->dao = new VotoDAO();
    }

    public function listarTodos(?int $meme_id = null): array {
        return $this->dao->listarTodos($meme_id);
    }


    public function criarVoto(int $meme_id, string $tipo): array {
        $tipo = strtolower($tipo);
        if (!in_array($tipo, ['like', 'dislike'], true)) {
            return [
                "erro"      => true,
                "mensagem"  => "Tipo de voto inválido. Use 'like' ou 'dislike'."
            ];
        }

        $novoId = $this->dao->inserir($meme_id, $tipo);
        $todos = $this->dao->listarTodos($meme_id);
        foreach ($todos as $voto) {
            if ((int)$voto['id'] === $novoId) {
                return $voto;
            }
        }

        return [
            "id"       => $novoId,
            "meme_id"  => $meme_id,
            "tipo"     => $tipo,
            "criado_em"=> date('Y-m-d H:i:s')
        ];
    }
}
