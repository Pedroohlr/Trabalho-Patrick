<?php

namespace controller;

use service\VotoService;

class Voto {

    public function listarTodos() {
        $service = new VotoService();
        return $service->listarTodos();
    }

    public function inserir(int $meme_id, string $tipo) {
        $service = new VotoService();
        return $service->criarVoto($meme_id, $tipo);
    }
}
