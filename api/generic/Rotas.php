<?php

namespace generic;

use generic\Retorno;

class Rotas
{
    private array $endpoints = [];

    public function __construct()
    {


        $this->endpoints = [
            "usuario/registrar" => new Acao([
                Acao::POST => new Endpoint("Usuario", "inserir")
            ]),
            "auth/login" => new Acao([
                Acao::POST => new Endpoint("Auth", "login")
            ]),

            "memes" => new Acao([
                Acao::GET => new Endpoint("Meme", "listarTodos"),
                Acao::POST => new Endpoint("Meme", "inserir"),
                Acao::PUT => new Endpoint("Meme", "atualizar"),
                Acao::DELETE => new Endpoint("Meme", "deletar")
            ]),

            "memes/buscar/id" => new Acao([
                Acao::GET => new Endpoint("Meme", "buscarPorId")
            ]),

            "memes/buscar/tagName" => new Acao([
                Acao::GET => new Endpoint("Meme", "buscarPorTagName")
            ]),

            "tags" => new Acao([
                Acao::GET => new Endpoint("Tag", "listar"),
                Acao::POST => new Endpoint("Tag", "inserir"),
                Acao::PUT => new Endpoint("Tag", "atualizar"),
                Acao::DELETE => new Endpoint("Tag", "deletar")
            ]),

            "votos" => new Acao([
                Acao::GET => new Endpoint("Voto", "listarTodos"),
                Acao::POST => new Endpoint("Voto", "inserir")
            ])
        ];
    }

    public function executar(string $rota)
    {
        try {
            if (isset($this->endpoints[$rota])) {
                $endpoint = $this->endpoints[$rota];
                $dados = $endpoint->executar();

                $retorno = new Retorno();

                if ($dados === false) {
                    $retorno->erro = true;
                    $retorno->mensagem = "Parâmetros obrigatórios faltando ou inválidos.";
                } elseif ($dados === null) {
                    http_response_code(405);
                    return [
                        "erro" => true,
                        "mensagem" => "Método HTTP '{$_SERVER['REQUEST_METHOD']}' não permitido para a rota '{$rota}'."
                    ];
                } else {
                    $retorno->erro = false;
                    $retorno->dados = $dados;
                }

                return $retorno;
            }

            http_response_code(404);
            return [
                "erro" => true,
                "mensagem" => "Rota '{$rota}' não encontrada."
            ];
        } catch (\Throwable $e) {
            http_response_code(500);
            return [
                "erro" => true,
                "mensagem" => "Erro interno durante a execução da rota.",
            ];
        }
    }
}
