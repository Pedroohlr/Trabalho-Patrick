<?php
namespace generic;

class MysqlFactory {
    protected MysqlSingleton $banco;

    public function __construct() {
        $this->banco = MysqlSingleton::getInstance();
    }
}
