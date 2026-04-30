<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

// Convierte caracteres especiales en entidades HTML para prevenir XSS
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}   

// Genera una URL completa para un recurso dado
function flash(string $key): ?string
{
    if (!isset($_SESSION[$key])) {
        return null;
    }

    $message = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $message;
}

// Devuelve el valor antiguo de un campo de formulario después de una redirección
function old(string $key, string $default = ''): string
{
    return e($_SESSION['old'][$key] ?? $default);
}

// Limpia los datos antiguos de formularios después de mostrarlos una vez
function clear_old(): void
{   
    unset($_SESSION['old']);
}

// Valida el formato de un RUT 
function rut_is_valid(string $rut): bool
{
    return preg_match('/^\d{7,8}-[\dKk]$/', $rut) === 1;
}
