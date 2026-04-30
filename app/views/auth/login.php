<!-- Muestra un formulario de inicio de sesión  -->
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3 mb-4">Iniciar sesión</h1>
                <form method="POST" action="<?= e(base_url('index.php?route=auth/login')) ?>">
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="clave" name="clave" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php clear_old(); ?>
