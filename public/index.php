<?php

// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';


// Autocarga de clases para modelos, controladores y clases core
spl_autoload_register(function (string $class): void {
    $paths = [
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/core/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

try {
    (new Router())->dispatch();
} catch (Throwable $e) {
    // registra el error y muestra un mensaje genérico al usuario
    http_response_code(500);
    file_put_contents(__DIR__ . '/../storage/logs/error.log', '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
    echo '<h1>Error interno</h1><p>Ocurrió un error al procesar la solicitud.</p>';
}
