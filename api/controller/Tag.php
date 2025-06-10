<?php

namespace controller;

use Middlewares\AuthMiddleware;
use service\TagService;

class Tag
{

    public function listar()
    {
        try{
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new TagService();
            return $service->listarTodas();
        }catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao listar categorias."
            ];
        }
    }

    public function inserir(string $nome)
    {
        try{
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new TagService();
            return $service->criarTag($nome);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao inserir categoria de meme."
            ];
        }
    }

    public function atualizar(int $id, string $nome)
    {
        try{
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new TagService();
            return $service->atualizarTag($id, $nome);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao atualizar categoria de meme."
            ];
        }
    }

    public function deletar(int $id)
    {
        try{
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new TagService();
            return $service->removerTag($id);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao deletar categoria de meme."
            ];
        }
    }
}
