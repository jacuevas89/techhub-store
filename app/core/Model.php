<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

abstract class Model
{
    // Propiedad para almacenar la conexión a la base de datos
    protected PDO $db;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}
