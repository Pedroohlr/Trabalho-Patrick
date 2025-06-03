<?php

spl_autoload_register(function(string $class) {
    $file = __DIR__ . "/../" . str_replace("\\", "/", $class) . ".php";
    if (file_exists($file)) {
        include $file;
    }
});

$rota = $_GET['param'] ?? '';
$router = new generic\Controller();
$router->verificarChamadas($rota);
