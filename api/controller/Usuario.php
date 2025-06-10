<?php

namespace controller;

use Middlewares\AuthMiddleware;
use service\UsuarioService;

class Usuario
{
    public function buscarPorId()
    {
        try {
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                return false;
            }
    
            $id = (int) $_GET['id'];
            $service = new UsuarioService();
            return $service->buscarPorId($id);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao buscar usuário por id."
            ];
        }
    }

    public function inserir(string $nome, string $email, string $senha)
    {
        try {
            $usuario = AuthMiddleware::verificarToken();
    
            $userId = $usuario->data->id;
    
            $service = new UsuarioService();
            return $service->criarUsuario($nome, $email, $senha);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao criar usuário."
            ];
        }
    }


}