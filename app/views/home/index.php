<section class="hero-techhub rounded-4 p-4 p-md-5 mb-4 text-white">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="badge text-bg-light text-dark mb-3">TechHub Store</span>
            <h1 class="display-6 fw-bold">Conecta con la tecnología del futuro</h1>
            <p class="lead mb-0">Encuentra lo último en notebooks, tablets y accesorios en una tienda pensada para quienes viven conectados, 
                crean más y van siempre un paso adelante.</p>
        </div>
        
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                
                <!--Formulario con filtros de búsqueda para productos  -->
                <div class="card-body">
                    <h2 class="h5 mb-3">Filtrar productos</h2>
                    <form id="filter-form" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Buscar</label>
                            <input type="text" class="form-control" name="search" placeholder="Nombre, categoría o descripción">
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Categoría</label>
                            <select class="form-select" name="categoria">
                                <option value="">Todas</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= e($category) ?>"><?= e($category) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>



                        <div class="col-md-6">
                            <label class="form-label">Subcategoría</label>
                            <select class="form-select" name="subcategoria">
                                <option value="">Todas</option>
                                <?php foreach ($subcategories as $subcategory): ?>
                                    <option value="<?= e($subcategory) ?>"><?= e($subcategory) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        
                        <div class="col-12 d-grid d-md-flex gap-2">
                            <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                            <button type="reset" class="btn btn-outline-secondary" id="reset-filters">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <!-- Título del listado de productos, con contador dinámico -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Productos disponibles</h2>
        <span class="text-muted" id="product-counter"><?= count($products) ?> productos</span>
    </div>

    <!-- Contenedor para el grid de productos, que se actualizará dinámicamente con JavaScript-->
    <div id="products-grid" class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="card product-card border-0 shadow-sm">
                <img class="card-img-top product-image" src="<?= e(base_url('public/assets/img/' . $product['imagen'])) ?>" alt="<?= e($product['nombre']) ?>">
                <div class="card-body d-flex flex-column">
                    <span class="badge text-bg-dark mb-2 align-self-start"><?= e($product['categoria']) ?></span>
                    <h3 class="h5"><?= e($product['nombre']) ?></h3>
                    <p class="text-muted small mb-2"><?= e($product['subcategoria']) ?></p>
                    <p class="text-muted flex-grow-1"><?= e($product['descripcion']) ?></p>
                    <div class="d-flex justify-content-between align-items-center mt-3 gap-2">
                        <strong class="text-primary fs-5">$<?= number_format((float)$product['precio'], 0, ',', '.') ?></strong>
                        
                        <!-- Botón de agregar al carrito -->
                        <button
                            class="btn btn-primary add-to-cart-btn"
                            data-id="<?= (int)$product['id_producto'] ?>"
                            data-name="<?= e($product['nombre']) ?>"
                            data-price="<?= (float)$product['precio'] ?>"
                            data-image="<?= e($product['imagen']) ?>"
                        >Agregar</button>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
