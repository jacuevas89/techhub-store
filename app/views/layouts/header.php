<?php
$success = flash('flash_success');
$error = flash('flash_error');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(base_url('public/assets/css/app.css')) ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= e(base_url('index.php')) ?>">TechHub Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= e(base_url('index.php')) ?>">Inicio</a></li>
                <?php if (!empty($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e(base_url('index.php?route=order/history')) ?>">Historial</a></li>
                    <?php if (!empty($_SESSION['user']['admin'])): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= e(base_url('index.php?route=admin/index')) ?>">Administración</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-light position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .49.402L2.89 3H14.5a.5.5 0 0 1 .49.598l-1.5 7A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.49-.402L1.61 2H.5A.5.5 0 0 1 0 1.5ZM3.102 4l1.286 6h8.21l1.286-6H3.102ZM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm6 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z"/>
                    </svg>
                    Carrito
                    <span id="cart-count" class="badge rounded-pill text-bg-info cart-count">0</span>
                </button>
                <?php if (!empty($_SESSION['user'])): ?>
                    <span class="text-light small">Hola, <?= e($_SESSION['user']['nombre']) ?></span>
                    <a class="btn btn-sm btn-warning" href="<?= e(base_url('index.php?route=auth/logout')) ?>">Salir</a>
                <?php else: ?>
                    <a class="btn btn-sm btn-outline-info" href="<?= e(base_url('index.php?route=auth/login')) ?>">Ingresar</a>
                    <a class="btn btn-sm btn-info text-white" href="<?= e(base_url('index.php?route=auth/register')) ?>">Registrarse</a>
                <?php endif; ?>
            </div> 
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        <?php if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
