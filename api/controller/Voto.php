<?php

namespace controller;

use Middlewares\AuthMiddleware;
use service\VotoService;

class Voto
{

public function listarTodos()
    {
        try {
            $usuario = AuthMiddleware::verificarToken();
            $userId = $usuario->data->id;

            $service = new VotoService();
            return $service->listarTodos();
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao listar votos."
            ];
        }
    }

    public function inserir(int $meme_id, string $tipo)
    {
        try {
            $usuario = AuthMiddleware::verificarToken();
            $userId = $usuario->data->id;

            $service = new VotoService();
            return $service->criarVoto($meme_id, $tipo);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao registrar voto."
            ];
        }
    }
}
