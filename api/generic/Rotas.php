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

            $retorno = new Retorno();

            $metodo = $_SERVER['REQUEST_METHOD'];

            if ($dados === false || $dados === null) {
                $retorno->erro = true;
                $retorno->mensagem = match ($metodo) {
                    "POST" => "Erro ao criar o registro. Verifique os dados enviados.",
                    "PUT" => "Erro ao atualizar o registro. Verifique se o ID e os dados são válidos.",
                    "DELETE" => "Erro ao excluir o registro. Verifique se o ID é válido.",
                    "GET" => "Nenhum dado encontrado para os parâmetros informados.",
                    default => "Erro na requisição."
                };
            } else {
                // Sucesso
                $retorno->erro = false;
                $retorno->dados = $dados;
                $retorno->mensagem = match ($metodo) {
                    "POST" => "Registro criado com sucesso.",
                    "PUT" => "Registro atualizado com sucesso.",
                    "DELETE" => "Registro excluído com sucesso.",
                    "GET" => is_array($dados) && count($dados) === 0
                    ? "Nenhum dado encontrado."
                    : "Consulta realizada com sucesso.",
                    default => "Operação realizada com sucesso."
                };
            }

            return $retorno;
        }

        return null;
    }
}
