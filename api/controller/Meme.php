<?php

namespace controller;

use Middlewares\AuthMiddleware;
use service\MemeService;

class Meme
{
    public function listarTodos()
    {
        try {
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new MemeService();
            return $service->listarTodos();
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao listar memes."
            ];
        }
    }

    public function buscarPorId()
    {
        try{
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                return false;
            }
    
            $id = (int) $_GET['id'];
            $service = new MemeService();
            return $service->buscarPorId($id);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao buscar meme."
            ];
        }
    }

    public function buscarPorTagName(string $tagName)
    {
        try {
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new MemeService();
            return $service->buscarPorTagName($tagName);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao buscar memes por categoria."
            ];
        }
    }

    public function inserir(string $titulo, string $imagem_url, string $legenda, string $autor, array $tags = [])
    {
        try {

            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new MemeService();
            return $service->criarMeme($titulo, $imagem_url, $legenda, $autor, $tags);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao criar meme."
            ];
        }
    }

    public function atualizar(int $id, ?string $titulo = null, ?string $imagem_url = null, ?string $legenda = null, ?string $autor = null, ?array $tags = null)
    {
        try {
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new MemeService();
            return $service->atualizarMeme($id, $titulo, $imagem_url, $legenda, $autor, $tags);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao atualizar meme."
            ];
        }
    }

    public function deletar(int $id)
    {
        try{
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new MemeService();
            return $service->removerMeme($id);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao deletar meme."
            ];
        }
    }
}
