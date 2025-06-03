<?php

namespace generic;

class Controller {
    private Rotas $rotas;

    public function __construct() {
        $this->rotas = new Rotas();
    }

    public function verificarChamadas(string $rota): void {
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
    }
}
