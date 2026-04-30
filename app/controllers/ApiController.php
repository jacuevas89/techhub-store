<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';


// Controlador para manejar las rutas de la API
class ApiController extends Controller
{
    // Devuelve la lista de productos con filtros 
    public function products(): void
    {
        $model = new Product();
        $this->json([
            'ok' => true,
            'products' => $model->getAll([
                'search' => trim($_GET['search'] ?? ''),
                'categoria' => trim($_GET['categoria'] ?? ''),
                'subcategoria' => trim($_GET['subcategoria'] ?? ''),
            ]),
        ]);
    }

    // Guarda el carrito del usuario en la base de datos
    public function saveCart(): void
    {
        $this->requireLogin();
        $payload = json_decode(file_get_contents('php://input'), true) ?: [];
        $items = $payload['items'] ?? [];
        (new Cart())->save($_SESSION['user']['rut'], $items);
        $this->json(['ok' => true, 'message' => 'Carrito guardado correctamente.']);
    }

    // Devuelve el carrito del usuario
    public function getCart(): void
    {
        $this->requireLogin();
        $items = (new Cart())->getByUser($_SESSION['user']['rut']);
        $this->json(['ok' => true, 'items' => $items]);
    }

    // Procesa el checkout y crea una orden de compra
    public function checkout(): void
    {
        $this->requireLogin();
        $payload = json_decode(file_get_contents('php://input'), true) ?: [];
        $items = $payload['items'] ?? [];

        if (!$items) {
            $this->json(['ok' => false, 'message' => 'El carrito está vacío.'], 422);
        }

        $orderId = (new Order())->create($_SESSION['user']['rut'], $items);
        
        // Se muestra un mensaje de éxito con el ID de la orden creada
        $this->json([
            'ok' => true,
            'message' => 'Plataforma de prueba: Pronto podrás comprar tus productos. Tu orden de prueba ha sido creada con ID: ' . $orderId,
            'order_id' => $orderId,
        ]);
    }
}
