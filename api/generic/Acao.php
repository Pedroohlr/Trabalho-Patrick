<?php

namespace generic;

use ReflectionMethod;

class Acao {
    const POST   = "POST";
    const GET    = "GET";
    const PUT    = "PUT";
    const PATCH  = "PATCH";
    const DELETE = "DELETE";

    public function __construct(array $endpoint = []) {
        $this->endpoint = $endpoint;
    }

    public function executar() {
        $end = $this->endpointMetodo();
        if (!$end) {
            return null;
        }

        $reflectMetodo = new ReflectionMethod($end->classe, $end->execucao);
        $parametros    = $reflectMetodo->getParameters();
        $returnParam   = $this->getParam();

        if (!empty($parametros)) {
            $args = [];
            foreach ($parametros as $param) {
                $name = $param->getName();
                if (!array_key_exists($name, $returnParam)) {
                    return false;
                }
                $args[] = $returnParam[$name];
            }
            return $reflectMetodo->invokeArgs(new $end->classe(), $args);
        }
        return $reflectMetodo->invoke(new $end->classe());
    }

    private function endpointMetodo(): ?Endpoint {
        $metodo = $_SERVER["REQUEST_METHOD"];
        return $this->endpoint[$metodo] ?? null;
    }

    private function getPost(): array {
        return $_POST ?? [];
    }

    private function getGet(): array {
        if (!isset($_GET)) {
            return [];
        }
        $get = $_GET;
        unset($get["param"]);
        return $get;
    }

    private function getInput(): array {
        $input = file_get_contents("php://input");
        if ($input) {
            $json = @json_decode($input, true);
            return is_array($json) ? $json : [];
        }
        return [];
    }

    public function getParam(): array {
        return array_merge($this->getPost(), $this->getGet(), $this->getInput());
    }
}
