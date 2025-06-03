<?php

namespace service;

use dao\mysql\MemeDAO;

class MemeService
{
    private MemeDAO $dao;

    public function __construct()
    {
        $this->dao = new MemeDAO();
    }

    public function listarTodos(): array
    {
        return $this->dao->listarTodos();
    }

    public function buscarPorId(int $id): ?array
    {
        return $this->dao->buscarPorId($id);
    }

    public function buscarPorTagName(string $tagName): array
    {
        return $this->dao->buscarPorTagName($tagName);
    }

    public function criarMeme(string $titulo, string $imagem_url, string $legenda, string $autor, array $tags = []): array
    {

        $novoId = $this->dao->inserir($titulo, $imagem_url, $legenda, $autor);

        if (!empty($tags)) {
            $this->dao->recriarTags($novoId, $tags);
        }

        return $this->dao->buscarPorId($novoId);
    }

    public function atualizarMeme(
        int $id,
        ?string $titulo,
        ?string $imagem_url,
        ?string $legenda,
        ?string $autor,
        ?array $tags
    ): ?array {
        $memeExistente = $this->dao->buscarPorId($id);
        if ($memeExistente === null) {
            return null;
        }

        $sucesso = $this->dao->atualizar($id, $titulo, $imagem_url, $legenda, $autor);
        if (!$sucesso) {
            return null;
        }

        if (is_array($tags)) {
            $this->dao->recriarTags($id, $tags);
        }

        return $this->dao->buscarPorId($id);
    }

    public function removerMeme(int $id): ?array
    {
        $memeExistente = $this->dao->buscarPorId($id);
        if ($memeExistente === null) {
            return null;
        }

        $this->dao->deletar($id);
        return ["meme removido" => true];
    }
}
