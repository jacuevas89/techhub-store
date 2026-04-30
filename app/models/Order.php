<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Model.php';

// Modelo para manejar las órdenes de compra realizadas por los usuarios
class Order extends Model
{
    // Crea una nueva orden de compra para un usuario dado con los productos seleccionados
    public function create(string $userRut, array $items): int
    {
        $this->db->beginTransaction();

        try {
            $productModel = new Product();
            $total = 0;
            $normalizedItems = [];

            foreach ($items as $item) {
                $product = $productModel->find((int)$item['id_producto']);
                if (!$product) {
                    throw new RuntimeException('Producto no encontrado: ' . $item['id_producto']);
                }

                // Asegura que la cantidad sea al menos 1 y calcula el subtotal para cada producto
                $cantidad = max(1, (int)$item['cantidad']);
                $precioUnitario = (float)$product['precio'];
                $subtotal = $precioUnitario * $cantidad;
                $total += $subtotal;

                $normalizedItems[] = [
                    'id_producto' => (int)$product['id_producto'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                ];
            }

            // Inserta la orden en la base de datos y obtiene su ID para insertar los detalles de la orden
            $stmt = $this->db->prepare('INSERT INTO ordenes (usuario_rut, total, estado) VALUES (:usuario_rut, :total, :estado)');
            $stmt->execute([
                ':usuario_rut' => $userRut,
                ':total' => $total,
                ':estado' => 'pendiente',
            ]);

            $orderId = (int)$this->db->lastInsertId();

            // Arma la consulta para insertar los detalles de la orden
            $detailStmt = $this->db->prepare('INSERT INTO detalles_orden (orden_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (:orden_id, :producto_id, :cantidad, :precio_unitario, :subtotal)');

            // Recorre los productos normalizados y los inserta en la tabla de detalles_orden
            foreach ($normalizedItems as $item) {
                $detailStmt->execute([
                    ':orden_id' => $orderId,
                    ':producto_id' => $item['id_producto'],
                    ':cantidad' => $item['cantidad'],
                    ':precio_unitario' => $item['precio_unitario'],
                    ':subtotal' => $item['subtotal'],
                ]);
            }

            // Limpia el carrito del usuario después de crear la orden
            $cartStmt = $this->db->prepare('INSERT INTO carritos (usuario_rut, cart_data) VALUES (:usuario_rut, :cart_data)
                ON DUPLICATE KEY UPDATE cart_data = VALUES(cart_data), fecha_registro = CURRENT_TIMESTAMP');
            $cartStmt->execute([
                ':usuario_rut' => $userRut,
                ':cart_data' => json_encode([], JSON_UNESCAPED_UNICODE),
            ]);

            $this->db->commit();
            return $orderId;
        } catch (Throwable $e) {
            
            $this->db->rollBack();
            throw $e;
        }
    }

    // Obtiene todas las órdenes de compra realizadas por un usuario específico, ordenadas por fecha de registro
    public function getByUser(string $rut): array
    {
        $stmt = $this->db->prepare('SELECT * FROM ordenes WHERE usuario_rut = :rut ORDER BY fecha_registro DESC');
        $stmt->execute([':rut' => $rut]);
        return $stmt->fetchAll();
    }

    // Obtiene los detalles de una orden específica para un usuario específico
    public function getDetails(int $orderId, string $rut): array
    {
        $stmt = $this->db->prepare('SELECT d.*, p.nombre, p.imagen
            FROM detalles_orden d
            INNER JOIN ordenes o ON o.id_orden = d.orden_id
            INNER JOIN productos p ON p.id_producto = d.producto_id
            WHERE d.orden_id = :order_id AND o.usuario_rut = :rut');
        $stmt->execute([':order_id' => $orderId, ':rut' => $rut]);
        return $stmt->fetchAll();
    }
}
