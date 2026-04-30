<?php
// Activa validación estricta de tipos en este archivo
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/helpers.php';

// Controlador para manejar autentificacion de usuarios
class AuthController extends Controller
{
    // Muestra el formulario de inicio de sesión y controla el proceso de autentificacion
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $clave = $_POST['clave'] ?? '';
            $_SESSION['old'] = ['email' => $email];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Verifica que el usuario exista y que la contraseña sea correcta
            if (!$user || !password_verify($clave, $user['clave_hash'])) {
                $_SESSION['flash_error'] = 'Credenciales inválidas.';
                $this->redirect('auth/login');
            }

            // Almacena la información del usuario en la sesión y redirige al inicio
            $_SESSION['user'] = [
                'rut' => $user['rut'],
                'nombre' => $user['nombre_completo'],
                'email' => $user['email'],
                'admin' => (int)$user['admin'],
            ];
            clear_old();
            $_SESSION['flash_success'] = 'Sesión iniciada correctamente.';
            $this->redirect('home/index');
        }

        $this->render('auth/login');
    }

    // Muestra el formulario de registro y controla el proceso de creación de nuevos usuarios
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rutCompleto = strtoupper(trim($_POST['rut_completo'] ?? ''));
            $rutNormalizado = trim(explode('-', $rutCompleto)[0]);
            $nombre = trim($_POST['nombre_completo'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $clave = $_POST['clave'] ?? '';

            // Almacena los datos ingresados para mostrarlos nuevamente en caso de error
            $_SESSION['old'] = [
                'rut_completo' => $rutCompleto,
                'nombre_completo' => $nombre,
                'email' => $email,
            ];

            // Validaciones de los campos del formulario
            if (!$rutCompleto || !$nombre || !$email || !$clave) {
                $_SESSION['flash_error'] = 'Todos los campos son obligatorios.';
                $this->redirect('auth/register');
            }

            if (!rut_is_valid($rutCompleto)) {
                $_SESSION['flash_error'] = 'El RUT ingresado no es válido.';
                $this->redirect('auth/register');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash_error'] = 'El correo electrónico no es válido.';
                $this->redirect('auth/register');
            }

            if (strlen($clave) < 8) {
                $_SESSION['flash_error'] = 'La contraseña debe tener al menos 8 caracteres.';
                $this->redirect('auth/register');
            }

            // Verifica que no exista otro usuario con el mismo RUT o correo
            $userModel = new User();
            if ($userModel->findByRut($rutNormalizado) || $userModel->findByEmail($email)) {
                $_SESSION['flash_error'] = 'Ya existe un usuario con ese RUT o correo.';
                $this->redirect('auth/register');
            }

            // Crea el nuevo usuario con la contraseña encodeada por seguridad
            $userModel->create([
                'rut' => $rutNormalizado,
                'rut_completo' => $rutCompleto,
                'nombre_completo' => $nombre,
                'email' => $email,
                'clave' => $clave,
            ]);

            clear_old();
            $_SESSION['flash_success'] = 'Registro realizado correctamente. Ahora puedes iniciar sesión.';
            $this->redirect('auth/login');
        }

        $this->render('auth/register');
    }

    // Hace logout del usuario destruyendo la sesión y redirigiendo al inicio
    public function logout(): void
    {
        session_destroy();
        session_start();
        $_SESSION['flash_success'] = 'Sesión cerrada correctamente.';
        $this->redirect('home/index');
    }
}
