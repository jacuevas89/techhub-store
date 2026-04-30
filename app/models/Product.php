<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Model.php';

class Product extends Model
{
    // Método para obtener todos los productos con filtros seleccionados
    public function getAll(array $filters = []): array
    {
        $sql = 'SELECT * FROM productos WHERE 1=1';
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= ' AND (nombre LIKE :search OR descripcion LIKE :search OR categoria LIKE :search OR subcategoria LIKE :search)';
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['categoria'])) {
            $sql .= ' AND categoria = :categoria';
            $params[':categoria'] = $filters['categoria'];
        }

        if (!empty($filters['subcategoria'])) {
            $sql .= ' AND subcategoria = :subcategoria';
            $params[':subcategoria'] = $filters['subcategoria'];
        }

        $sql .= ' ORDER BY id_producto DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Método para obtener un producto según ID
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM productos WHERE id_producto = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    // Métodos para obtener categorías unicas para el filtro
    public function getCategories(): array
    {
        return $this->db->query('SELECT DISTINCT categoria FROM productos ORDER BY categoria ASC')->fetchAll(PDO::FETCH_COLUMN);
    }

    // Métodos para obtener subcategorías unicas para el filtro
    public function getSubcategories(): array
    {
        return $this->db->query('SELECT DISTINCT subcategoria FROM productos ORDER BY subcategoria ASC')->fetchAll(PDO::FETCH_COLUMN);
    }

    // Método para crear  producto
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO productos (nombre, descripcion, precio, categoria, subcategoria, imagen) VALUES (:nombre, :descripcion, :precio, :categoria, :subcategoria, :imagen)');
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':precio' => $data['precio'],
            ':categoria' => $data['categoria'],
            ':subcategoria' => $data['subcategoria'],
            ':imagen' => $data['imagen'],
        ]);
    }

    // Método para editar producto
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, categoria = :categoria, subcategoria = :subcategoria, imagen = :imagen WHERE id_producto = :id');
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':precio' => $data['precio'],
            ':categoria' => $data['categoria'],
            ':subcategoria' => $data['subcategoria'],
            ':imagen' => $data['imagen'],
        ]);
    }

    // Métodos para eliminar producto
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM productos WHERE id_producto = :id');
        return $stmt->execute([':id' => $id]);
    }
}
