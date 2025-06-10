<?php

namespace service;

use dao\mysql\AuthDAO;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    private AuthDAO $dao;

    public function __construct()
    {
        $this->dao = new AuthDAO();
    }

    public function login($email, $senha) {
        $user = $this->dao->buscarPorEmail($email);

        if ($user && $senha === $user['senha']) {
            $payload = [
                "iss" => "localhost/api_memes",
                "aud" => "localhost/api_memes",
                "iat" => time(),
                "exp" => time() + (60 * 60), // 1 hora de expiração
                "data" => [
                    "id" => $user['id'],
                    "email" => $user['email']
                ]
            ];

            $chave_secreta = "sua_chave_secreta";

            $jwt = JWT::encode($payload, $chave_secreta, 'HS256');

            return ["token" => $jwt];
        }

        return null;
    }
}