<?php

namespace controller;

use service\AuthService;

class Auth
{
    public function login(string $email, string $senha)
    {
        try {
            $service = new AuthService();
            return $service->login($email, $senha);
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro ao realizar login."
            ];
        }
    }
}