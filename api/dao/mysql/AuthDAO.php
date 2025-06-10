<?php

namespace dao\mysql;

use generic\MysqlFactory;

class AuthDAO extends MysqlFactory
{
    public function __construct()
    {
        parent::__construct();
    }

        public function buscarPorEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $resultado = $this->banco->executar($sql, [':email' => $email]);

        return count($resultado) > 0 ? $resultado[0] : null;
    }
}