<?php
require_once __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function(string $class) {
    $file = __DIR__ . "/../" . str_replace("\\", "/", $class) . ".php";
    if (file_exists($file)) {
        include $file;
    }
});

$rota = $_GET['param'] ?? '';

try {
    $router = new generic\Controller();
    $router->verificarChamadas($rota);
} catch (\Throwable $e) {
    // Resposta padrão para erros inesperados
    http_response_code(500);
    echo json_encode([
        'erro' => true,
        'mensagem' => 'Erro interno no servidor.'
    ]);
}
