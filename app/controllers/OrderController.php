<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Order.php';

class OrderController extends Controller
{
    // Muestra el historial de órdenes del usuario
    public function history(): void
    {
        $this->requireLogin();
        $orderModel = new Order();
        $orders = $orderModel->getByUser($_SESSION['user']['rut']);

        foreach ($orders as &$order) {
            $order['items'] = $orderModel->getDetails((int)$order['id_orden'], $_SESSION['user']['rut']);
        }

        $this->render('orders/history', ['orders' => $orders]);
    }
}
