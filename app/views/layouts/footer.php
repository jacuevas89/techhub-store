
<!-- Footer común para todas las vistas, con cierre de contenedores abiertos en header.php y home/index.php -->
    </div>
</main>

<!-- Panel lateral del carrito de compra. Muestra listado dinámico de los productos agregados al carrito-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartCanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Carrito de compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div id="cart-items" class="mb-3"></div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Total:</strong>
            <strong id="cart-total">$0</strong>
        </div>
        <?php if (!empty($_SESSION['user'])): ?>
            <button class="btn btn-primary w-100 mb-2" id="save-cart-btn">Guardar carrito</button>
            <button class="btn btn-success w-100" id="checkout-btn">Comprar y pagar</button>
        <?php else: ?>
            
            <div class="alert alert-warning small mb-0" role="alert">
                Debes iniciar sesión para guardar el carrito o finalizar la compra.
            </div><br>
            <a class="btn btn-primary w-100" href="<?= e(base_url('index.php?route=auth/login')) ?>">Iniciar sesión</a>
        <?php endif; ?>
    </div>
</div>

<footer class="border-top py-4 bg-white">
    <div class="container text-center text-muted small">
        <div>TechHub Store &reg;<br> Conecta con la tecnología del futuro <br>Sitio programado por Javier Cuevas Alfaro</div>
    </div>
</footer>

<script>
    window.TECHHUB = {
        baseUrl: <?= json_encode(base_url()) ?>,
        isLogged: <?= !empty($_SESSION['user']) ? 'true' : 'false' ?>
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="public/assets/js/app.js"></script>
</body>
</html>
