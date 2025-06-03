<?php

namespace generic;

class Rotas
{
    private array $endpoints = [];

    public function __construct()
    {


        $this->endpoints = [
            "memes" => new Acao([
                Acao::GET => new Endpoint("Meme", "listarTodos"),      // listar todos
                Acao::POST => new Endpoint("Meme", "inserir"),     // criar meme
                Acao::PUT => new Endpoint("Meme", "atualizar"),   // atualizar meme
                Acao::DELETE => new Endpoint("Meme", "deletar")      // deletar meme
            ]),

            "memes/buscar/id" => new Acao([
                Acao::GET => new Endpoint("Meme", "buscarPorId")
            ]),

            "memes/buscar/tagName" => new Acao([
                Acao::GET => new Endpoint("Meme", "buscarPorTagName")
            ]),

            "tags" => new Acao([
                Acao::GET => new Endpoint("Tag", "listar"), // listar todas as tags
                Acao::POST => new Endpoint("Tag", "inserir"), // criar tag
                Acao::PUT => new Endpoint("Tag", "atualizar"), // atualizar tag
                Acao::DELETE => new Endpoint("Tag", "deletar") // deletar tag
            ]),

            "votos" => new Acao([
                Acao::GET => new Endpoint("Voto", "listarTodos"),
                Acao::POST => new Endpoint("Voto", "inserir")
            ])
        ];
    }

    public function executar(string $rota)
    {
        if (isset($this->endpoints[$rota])) {
            $endpoint = $this->endpoints[$rota];
            $dados = $endpoint->executar();

            // Monta a resposta genérica
            $retorno = new Retorno();
            if ($dados === false) {
                $retorno->erro = true;
                $retorno->mensagem = "Parâmetros obrigatórios faltando ou inválidos.";
            } else {
                $retorno->erro = false;
                $retorno->dados = $dados;
            }
            return $retorno;
        }

        return null;
    }
}
