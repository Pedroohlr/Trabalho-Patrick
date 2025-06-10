<?php

namespace generic;

class Controller {
    private Rotas $rotas;

    public function __construct() {
        $this->rotas = new Rotas();
    }

    public function verificarChamadas(string $rota): void {
        try {
            $retorno = $this->rotas->executar($rota);

            if ($retorno !== null) {
                if ($retorno === false) {
                    http_response_code(400);
                    echo json_encode([
                        "erro"      => true,
                        "mensagem"  => "Requisição inválida ou parâmetros faltando."
                    ]);
                    return;
                }

                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($retorno);
                return;
            }

            http_response_code(404);
            echo json_encode([
                "erro"      => true,
                "mensagem"  => "Rota não existe."
            ]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                "erro"     => true,
                "mensagem" => "Erro interno ao processar a requisição."
            ]);
        }
    }
}
