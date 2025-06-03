<?php

namespace service;

use dao\mysql\TagDAO;

class TagService
{
    private TagDAO $dao;

    public function __construct()
    {
        $this->dao = new TagDAO();
    }

    public function listarTodas(): array
    {
        return $this->dao->listarTodas();
    }

    public function criarTag(string $nome): array
    {
        $novoId = $this->dao->inserir($nome);
        $todas = $this->dao->listarTodas();
        foreach ($todas as $t) {
            if ((int) $t['id'] === $novoId) {
                return $t;
            }
        }
        return ["id" => $novoId, "nome" => $nome];
    }

    public function atualizarTag(
        int $id,
        ?string $nome
    ): ?array {
        $tagExistente = $this->dao->buscarPorId($id);
        if ($tagExistente === null) {
            return null;
        }

        $sucesso = $this->dao->atualizar($id, $nome);
        if (!$sucesso) {
            return null;
        }

        return $this->dao->buscarPorId($id);
    }

    public function removerTag(int $id): ?array
    {
        $tagExistente = $this->dao->buscarPorId($id);
        if ($tagExistente === null) {
            return null;
        }

        $this->dao->deletar($id);
        return ["tag removida" => true];
    }
}
