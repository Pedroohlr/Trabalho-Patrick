<?php

namespace controller;

use service\MemeService;

class Meme
{
    public function listarTodos() {
        $service = new MemeService();
        return $service->listarTodos();
    }

    public function buscarPorId() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return false; // Parâmetro inválido
        }

        $id = (int) $_GET['id'];
        $service = new MemeService();
        return $service->buscarPorId($id);
    }

    public function buscarPorTagName(string $tagName) {
        $service = new MemeService();
        return $service->buscarPorTagName($tagName);
    }

    public function inserir(string $titulo, string $imagem_url, string $legenda, string $autor, array $tags = [])
    {
        $service = new MemeService();
        return $service->criarMeme($titulo, $imagem_url, $legenda, $autor, $tags);
    }

    public function atualizar(int $id, ?string $titulo = null, ?string $imagem_url = null, ?string $legenda = null, ?string $autor = null, ?array $tags = null)
    {
        $service = new MemeService();
        return $service->atualizarMeme($id, $titulo, $imagem_url, $legenda, $autor, $tags);
    }

    public function deletar(int $id)
    {
        $service = new MemeService();
        return $service->removerMeme($id);
    }
}
