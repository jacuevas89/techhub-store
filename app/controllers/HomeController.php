<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';

class HomeController extends Controller
{
    // Muestra la página de inicio con la lista de productos
    public function index(): void
    {
        $productModel = new Product();
        $this->render('home/index', [
            'products' => $productModel->getAll(),
            'categories' => $productModel->getCategories(),
            'subcategories' => $productModel->getSubcategories(),
        ]);
    }
}
