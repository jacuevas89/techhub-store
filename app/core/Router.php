<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

class Router
{
    // Método para despachar la solicitud a la ruta correspondiente
    public function dispatch(): void
    {
        $route = $_GET['route'] ?? 'home/index';
        $route = trim($route, '/');
        [$controllerSegment, $action] = array_pad(explode('/', $route, 2), 2, DEFAULT_ACTION);

        $controllerName = ucfirst($controllerSegment) . 'Controller';
        $action = $action ?: DEFAULT_ACTION;

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        //
        if (!file_exists($controllerFile)) {
            http_response_code(404);
            echo 'Controlador no encontrado.';
            return;
        }

        
        require_once $controllerFile;
        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo 'Acción no encontrada.';
            return;
        }

        $controller->{$action}();
    }
}
