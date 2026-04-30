<!-- Será null si no se está editando, o un array con los datos del producto a editar -->
<?php $productToEdit = $productToEdit ?? null; ?>
<div class="row g-4">
    <div class="col-xl-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-3"><?= $productToEdit ? 'Editar producto' : 'Nuevo producto' ?></h1>
                <!-- Formulario para crear o editar productos -->
                <form method="POST" action="<?= e(base_url('index.php?route=admin/saveProduct')) ?>" class="row g-3">
                    <input type="hidden" name="id_producto" value="<?= e((int)($productToEdit['id_producto'] ?? '')) ?>">
                    <div class="col-12">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?= e($productToEdit['nombre'] ?? '') ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" required><?= e($productToEdit['descripcion'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="1" min="1" name="precio" class="form-control" value="<?= e((int)($productToEdit['precio'] ?? '')) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Imagen predefinida</label>
                        <select name="imagen" class="form-select" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($imagenesDisponibles as $imagen): ?>
                                <option value="<?= e($imagen) ?>" <?= ($productToEdit['imagen'] ?? '') === $imagen ? 'selected' : '' ?>><?= e($imagen) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
        

                    <div class="col-md-6">
                        <label class="form-label">Categoría</label>
                        <select name="categoria" class="form-select" required>
                            <option value="">Seleccionar</option>
                            <?php foreach (($categoriasDisponibles ?? []) as $categoria): ?>
                                <option value="<?= e($categoria) ?>" <?= (($productToEdit['categoria'] ?? '') === $categoria) ? 'selected' : '' ?>>
                                    <?= e($categoria) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Subcategoría</label>
                        <select name="subcategoria" class="form-select" required>
                            <option value="">Seleccionar</option>
                            <?php foreach (($subcategoriasDisponibles ?? []) as $subcategoria): ?>
                                <option value="<?= e($subcategoria) ?>" <?= (($productToEdit['subcategoria'] ?? '') === $subcategoria) ? 'selected' : '' ?>>
                                    <?= e($subcategoria) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary"><?= $productToEdit ? 'Actualizar' : 'Guardar' ?></button>
                        <a href="<?= e(base_url('index.php?route=admin/index')) ?>" class="btn btn-outline-secondary">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-xl-7">
        <!-- Listado de productos existentes-->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="h4 mb-3">Productos</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= (int)$product['id_producto'] ?></td>
                                    <td><?= e($product['nombre']) ?></td>
                                    <td><?= e($product['categoria']) ?> / <?= e($product['subcategoria']) ?></td>
                                    <td>$<?= number_format((float)$product['precio'], 0, ',', '.') ?></td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-primary" href="<?= e(base_url('index.php?route=admin/editProduct&id=' . $product['id_producto'])) ?>">Editar</a>
                                        <form method="POST" action="<?= e(base_url('index.php?route=admin/deleteProduct')) ?>" class="d-inline">
                                            <input type="hidden" name="id" value="<?= (int)$product['id_producto'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
                                <!-- Gestor de usuarios -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h4 mb-3">Gestor de usuarios</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Admin</th>
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= e($user['rut_completo']) ?></td>
                                    <td><?= e($user['nombre_completo']) ?></td>
                                    <td><?= e($user['email']) ?></td>
                                    <td><?= (int)$user['admin'] === 1 ? 'Sí' : 'No' ?></td>
                                    <td class="text-end">
                                        <form method="POST" action="<?= e(base_url('index.php?route=admin/toggleAdmin')) ?>">
                                            <input type="hidden" name="rut" value="<?= e($user['rut']) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-dark">Cambiar admin</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
