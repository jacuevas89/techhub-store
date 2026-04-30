<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

// Configuración de la base de datos y otras constantes 
const DB_HOST = 'localhost';
const DB_NAME = 'techhub_store';
const DB_USER = 'root';
const DB_PASS = 'gop2025';

const APP_NAME = 'TechHub Store';
const DEFAULT_CONTROLLER = 'HomeController';
const DEFAULT_ACTION = 'index';

// Genera una URL completa para un recurso dado
function base_url(string $path = ''): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

    if ($base === '/' || $base === '.') {
        $base = '';
    }

    return $base . ($path ? '/' . ltrim($path, '/') : '');
}
