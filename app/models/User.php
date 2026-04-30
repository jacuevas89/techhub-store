<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Model.php';

// Modelo para manejar los usuarios registrados en el sistema
class User extends Model
{
    // Crea un nuevo usuario en la base de datos con los datos proporcionados en el formulario
    public function create(array $data): bool
    {
        $sql = 'INSERT INTO usuarios (rut, rut_completo, nombre_completo, email, clave_hash, admin) VALUES (:rut, :rut_completo, :nombre_completo, :email, :clave_hash, 0)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':rut' => $data['rut'],
            ':rut_completo' => $data['rut_completo'],
            ':nombre_completo' => $data['nombre_completo'],
            ':email' => $data['email'],
            ':clave_hash' => password_hash($data['clave'], PASSWORD_DEFAULT),
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function findByRut(string $rut): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE rut = :rut LIMIT 1');
        $stmt->execute([':rut' => $rut]);
        return $stmt->fetch() ?: null;
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT rut, rut_completo, nombre_completo, email, admin, fecha_registro FROM usuarios ORDER BY nombre_completo ASC')->fetchAll();
    }

    public function toggleAdmin(string $rut): bool
    {
        $stmt = $this->db->prepare('UPDATE usuarios SET admin = CASE WHEN admin = 1 THEN 0 ELSE 1 END WHERE rut = :rut');
        return $stmt->execute([':rut' => $rut]);
    }
}
