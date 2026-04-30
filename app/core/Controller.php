<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);


abstract class Controller
{
    // Método para renderizar vistas
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new RuntimeException('Vista no encontrada: ' . $view);
        }

        include __DIR__ . '/../views/layouts/header.php';
        include $viewFile;
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // Método para redirigir a una ruta específica
    protected function redirect(string $route): void
    {
        header('Location: ' . base_url('index.php?route=' . $route));
        exit;
    }

    // Métodos para manejo de autenticación
    protected function isLogged(): bool
    {
        return !empty($_SESSION['user']);
    }

    // Método para verificar que el usuario esté autenticado antes de acceder a las rutas
    protected function requireLogin(): void
    {
        if (!$this->isLogged()) {
            $_SESSION['flash_error'] = 'Debes iniciar sesión para continuar.';
            $this->redirect('auth/login');
        }
    }

    // Método para verificar que el usuario tenga permisos de administrador para acceder al panel de administrador
    protected function requireAdmin(): void
    {
        $this->requireLogin();

        if (empty($_SESSION['user']['admin'])) {
            $_SESSION['flash_error'] = 'No tienes permisos para acceder al panel de administración.';
            $this->redirect('home/index');
        }
    }

    // Método para enviar respuestas JSON
    protected function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
