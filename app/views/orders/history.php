<!-- Vista para mostrar el historial de compras del usuario -->
<h1 class="h3 mb-4">Historial de compras</h1>

<?php if (!$orders): ?>
    <!-- Si el usuario no tiene órdenes, muestra un mensaje  -->
    <div class="alert alert-info">Aún no tienes compras registradas.</div>
<?php else: ?>
    <!-- Lista de órdenes del usuario -->
    <div class="vstack gap-3">
        <?php foreach ($orders as $order): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                        <div>
                            <h2 class="h5 mb-1">Orden #<?= (int)$order['id_orden'] ?></h2>
                            <p class="text-muted mb-0">Fecha: <?= e($order['fecha_registro']) ?> · Estado: <?= e($order['estado']) ?></p>
                        </div>
                        <strong class="text-primary">Total: $<?= number_format((int)$order['total'], 0, ',', '.') ?></strong>
                    </div>
                    <div class="row g-3">
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 d-flex gap-3 align-items-center">
                                    <img src="<?= e(base_url('public/assets/img/' . $item['imagen'])) ?>" alt="<?= e($item['nombre']) ?>" class="history-thumb">
                                    <div>
                                        <strong><?= e($item['nombre']) ?></strong>
                                        <div class="small text-muted">Cantidad: <?= (int)$item['cantidad'] ?></div>
                                        <div class="small text-muted">Subtotal: $<?= number_format((int)$item['subtotal'], 0, ',', '.') ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
