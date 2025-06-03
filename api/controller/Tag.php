<?php

namespace controller;

use service\TagService;

class Tag {

    public function listar() {
        $service = new TagService();
        return $service->listarTodas();
    }

    public function inserir(string $nome) {
        $service = new TagService();
        return $service->criarTag($nome);
    }

    public function atualizar(int $id, string $nome)
    {
        $service = new TagService();
        return $service->atualizarTag($id, $nome);
    }

        public function deletar(int $id)
    {
        $service = new TagService();
        return $service->removerTag($id);
    }
}
