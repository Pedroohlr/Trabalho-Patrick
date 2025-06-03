<?php

namespace generic;

class Endpoint {
    public string $classe;
    public string $execucao;

    public function __construct(string $classe, string $execucao) {
        $this->classe   = "controller\\" . $classe;
        $this->execucao = $execucao; 
    }

    public function executar() {

        $controller = new $this->classe();


        if (isset($_GET['id'])) {

            return $controller->{$this->execucao}((int) $_GET['id']);
        } else {

            return $controller->{$this->execucao}();
        }
    }
}

