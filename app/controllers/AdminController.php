<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';

// Controlador para manejar las rutas del panel de administración
class AdminController extends Controller
{
    // Lista de imágenes disponibles para asignar a los productos
    private array $imagenesDisponibles = [
        'notebook.jpg', 'tablet.jpg', 'smartphone.jpg', 'monitor.jpg', 'teclado.jpg',
        'mouse.jpg', 'audifonos.jpg', 'impresora.jpg', 'webcam.jpg', 'router.jpg',
        'ssd.jpg', 'memoria-ram.jpg', 'pc-escritorio.jpg', 'smartwatch.jpg', 'cable-usb.jpg'
    ];

    // Muestra el dashboard de administración con la lista de productos y usuarios
    public function index(): void
    {
        $this->requireAdmin();
        $productModel = new Product();
        $userModel = new User();

        $this->render('admin/index', [
            'products' => $productModel->getAll(),
            'users' => $userModel->getAll(),
            'imagenesDisponibles' => $this->imagenesDisponibles,
            'categoriasDisponibles' => $productModel->getCategories(),
            'subcategoriasDisponibles' => $productModel->getSubcategories(),
        ]);
    }

    // Guarda un nuevo producto o actualiza uno existente
    public function saveProduct(): void
    {
        $this->requireAdmin();

        $id = (int)($_POST['id_producto'] ?? 0);
        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => (int)($_POST['precio'] ?? 0),
            'categoria' => trim($_POST['categoria'] ?? ''),
            'subcategoria' => trim($_POST['subcategoria'] ?? ''),
            'imagen' => trim($_POST['imagen'] ?? ''),
        ];

        // Validación de los campos del producto
        if (!$data['nombre'] || !$data['descripcion'] || $data['precio'] <= 0 || !$data['categoria'] || !$data['subcategoria'] || !$data['imagen']) {
            $_SESSION['flash_error'] = 'Completa todos los campos del producto.';
            $this->redirect('admin/index');
        }

        
        $productModel = new Product();

        // Si ID existe, se actualiza el producto existente; sino, se crea uno nuevo
        if ($id > 0) {
            $productModel->update($id, $data);
            $_SESSION['flash_success'] = 'Producto actualizado correctamente.';
        } else {
            $productModel->create($data);
            $_SESSION['flash_success'] = 'Producto creado correctamente.';
        }

        $this->redirect('admin/index');
    }



    // Muestra el formulario de edición para un producto específico
    public function editProduct(): void
    {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            $_SESSION['flash_error'] = 'Producto no encontrado.';
            $this->redirect('admin/index');
        }

        $userModel = new User();

        $this->render('admin/index', [
            'products' => $productModel->getAll(),
            'users' => $userModel->getAll(),
            'productToEdit' => $product,
            'imagenesDisponibles' => $this->imagenesDisponibles,
            'categoriasDisponibles' => $productModel->getCategories(),
            'subcategoriasDisponibles' => $productModel->getSubcategories(),
        ]);
    }


    // Elimina un producto de la base de datos
    public function deleteProduct(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id'] ?? 0);

        if ($id > 0) {
            (new Product())->delete($id);
            $_SESSION['flash_success'] = 'Producto eliminado correctamente.';
        }

        $this->redirect('admin/index');
    }

    // Alterna el permiso de administrador para un usuario específico
    public function toggleAdmin(): void
    {
        $this->requireAdmin();
        $rut = trim($_POST['rut'] ?? '');

        if ($rut === ($_SESSION['user']['rut'] ?? '')) {
            $_SESSION['flash_error'] = 'No puedes quitarte o darte permisos desde tu propia sesión.';
            $this->redirect('admin/index');
        }

        (new User())->toggleAdmin($rut);
        $_SESSION['flash_success'] = 'Permiso de administrador actualizado.';
        $this->redirect('admin/index');
    }
}
