<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Model.php';

// Modelo para manejar el carrito de compras de los usuarios
class Cart extends Model
{
    // Guarda el estado del carrito de compras para un usuario específico
    public function save(string $rut, array $items): bool
    {
        // Inserta o actualiza el carrito de compras del usuario
        $stmt = $this->db->prepare('INSERT INTO carritos (usuario_rut, cart_data) VALUES (:usuario_rut, :cart_data)
            ON DUPLICATE KEY UPDATE cart_data = VALUES(cart_data), fecha_registro = CURRENT_TIMESTAMP');

        return $stmt->execute([
            ':usuario_rut' => $rut,
            ':cart_data' => json_encode($items, JSON_UNESCAPED_UNICODE),
        ]);
    }

    // Busca el carrito de compras de un usuario y devuelve un array vacío si no existe
    public function getByUser(string $rut): array
    {
        $stmt = $this->db->prepare('SELECT cart_data FROM carritos WHERE usuario_rut = :rut LIMIT 1');
        $stmt->execute([':rut' => $rut]);
        $data = $stmt->fetchColumn();
        return $data ? (json_decode($data, true) ?: []) : [];
    }
}
