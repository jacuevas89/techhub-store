<!-- Muestra un formulario de registro para nuevos usuarios-->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3 mb-4">Registro de usuario</h1>
                <form method="POST" action="<?= e(base_url('index.php?route=auth/register')) ?>" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">RUT completo</label>
                        <input type="text" name="rut_completo" class="form-control" value="<?= old('rut_completo') ?>" placeholder="12345678-5" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="nombre_completo" class="form-control" value="<?= old('nombre_completo') ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Contraseña</label>
                        <input type="clave" name="clave" class="form-control" minlength="8" required>
                    </div>
                    <div class="col-12 d-grid">
                        <button type="submit" class="btn btn-primary">Crear cuenta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php clear_old(); //Limpia los datos del formulario ?>
