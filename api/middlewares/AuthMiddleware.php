<?php
namespace Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    private static $chave_secreta = "sua_chave_secreta";

    public static function verificarToken() {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            exit(json_encode(['erro' => 'Token não enviado']));
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        try {
            $decodificado = JWT::decode($token, new Key(self::$chave_secreta, 'HS256'));
            return $decodificado;
        } catch (\Exception $e) {
            http_response_code(401);
            exit(json_encode(['erro' => 'Token inválido ou expirado']));
        }
    }
}