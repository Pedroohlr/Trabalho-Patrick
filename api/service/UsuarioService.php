<?php

namespace service;

use dao\mysql\UsuarioDAO;

class UsuarioService
{

    private UsuarioDAO $dao;

    public function __construct()
    {
        $this->dao = new UsuarioDAO();
    }

    public function buscarPorId(int $id): ?array
    {
        return $this->dao->buscarPorId($id);
    }

    public function criarUsuario(string $nome, string $email, string $senha)
    {

        $novoId = $this->dao->inserir($nome, $email, $senha);

        return $this->dao->buscarPorId($novoId);
    }

}