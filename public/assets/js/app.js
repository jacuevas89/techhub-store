(function () {
    
    
    const baseUrl = window.TECHHUB?.baseUrl || '';
    const productGrid = document.getElementById('products-grid');
    
    
    
    const productCounter = document.getElementById('product-counter');
    const filterForm = document.getElementById('filter-form');
    const resetFilters = document.getElementById('reset-filters');
    
    
    const cartItemsEl = document.getElementById('cart-items');
    const cartTotalEl = document.getElementById('cart-total');
    const cartCountEl = document.getElementById('cart-count');
    
    const saveCartBtn = document.getElementById('save-cart-btn');
    const checkoutBtn = document.getElementById('checkout-btn');
    const storageKey = 'techhub_cart';

    const money = (value) => new Intl.NumberFormat('es-CL').format(Number(value || 0));
    const getCart = () => JSON.parse(localStorage.getItem(storageKey) || '[]');
    const setCart = (cart) => localStorage.setItem(storageKey, JSON.stringify(cart));

    const toast = (message) => alert(message);

    // Función para renderizar productos 
    function renderProducts(products) {
        if (!productGrid) return;
        productCounter.textContent = `${products.length} productos`;
        productGrid.innerHTML = '';

        if (!products.length) {
            productGrid.innerHTML = '<div class="alert alert-warning">No se encontraron productos con esos filtros.</div>';
            return;
        }

        products.forEach((product) => {
            const html = `
                <article class="card product-card border-0 shadow-sm">
                    <img class="card-img-top product-image" src="${baseUrl}/public/assets/img/${product.imagen}" alt="${product.nombre}">
                    <div class="card-body d-flex flex-column">
                        <span class="badge text-bg-dark mb-2 align-self-start">${product.categoria}</span>
                        <h3 class="h5">${product.nombre}</h3>
                        <p class="text-muted small mb-2">${product.subcategoria}</p>
                        <p class="text-muted flex-grow-1">${product.descripcion}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 gap-2">
                            <strong class="text-primary fs-5">$${money(product.precio)}</strong>
                            <button class="btn btn-primary add-to-cart-btn" data-id="${product.id_producto}" data-name="${product.nombre}" data-price="${product.precio}" data-image="${product.imagen}">Agregar</button>
                        </div>
                    </div>
                </article>`;
            productGrid.insertAdjacentHTML('beforeend', html);
        });
    }

    // Función AJAX que consulta productos al backend 
    async function fetchProducts(params = {}) {
        const query = new URLSearchParams(params).toString();
        const response = await fetch(`${baseUrl}/index.php?route=api/products&${query}`);
        const data = await response.json();
        renderProducts(data.products || []);
    }

    // Funciones para manejar el carrito de compras
    function renderCart() {
        if (!cartItemsEl) return;
        const cart = getCart();
        cartItemsEl.innerHTML = '';

        if (!cart.length) {
            cartItemsEl.innerHTML = '<p class="text-muted">Tu carrito está vacío.</p>';
            cartTotalEl.textContent = '$0';
            cartCountEl.textContent = '0';
            return;
        }

        let total = 0;
        let count = 0;

        cart.forEach((item) => {
            total += Number(item.price) * Number(item.quantity);
            count += Number(item.quantity);
            const html = `
                <div class="cart-row">
                    <img src="${baseUrl}/public/assets/img/${item.image}" alt="${item.name}">
                    <div>
                        <strong>${item.name}</strong>
                        <div class="small text-muted">$${money(item.price)} c/u</div>
                    </div>
                    <div class="cart-actions">
                        <button class="btn btn-sm btn-outline-secondary" data-action="decrease" data-id="${item.id}">-</button>
                        <span>${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" data-action="increase" data-id="${item.id}">+</button>
                        <button class="btn btn-sm btn-outline-danger" data-action="remove" data-id="${item.id}">x</button>
                    </div>
                </div>`;
            cartItemsEl.insertAdjacentHTML('beforeend', html);
        });

        cartTotalEl.textContent = `$${money(total)}`;
        cartCountEl.textContent = String(count);
    }

    // Agrega un producto al carrito o incrementa su cantidad si ya existe
    function addToCart(button) {
        const cart = getCart();
        const id = Number(button.dataset.id);
        const existing = cart.find((item) => Number(item.id) === id);

        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({
                id,
                id_producto: id,
                name: button.dataset.name,
                price: Number(button.dataset.price),
                image: button.dataset.image,
                quantity: 1,
                cantidad: 1,
            });
        }

        cart.forEach((item) => item.cantidad = item.quantity);
        setCart(cart);
        renderCart();
    }

    // Actualiza la cantidad de un producto en el carrito o lo elimina si la cantidad llega a cero
    function updateCart(action, id) {
        let cart = getCart();
        const item = cart.find((p) => Number(p.id) === Number(id));
        if (!item) return;

        if (action === 'increase') item.quantity += 1;
        if (action === 'decrease') item.quantity -= 1;
        if (action === 'remove' || item.quantity <= 0) {
            cart = cart.filter((p) => Number(p.id) !== Number(id));
        }

        cart.forEach((entry) => entry.cantidad = entry.quantity);
        setCart(cart);
        renderCart();
    }

    // Función AJAX para guardar el carrito en el backend 
    async function saveCartRemote() {
        const items = getCart().map((item) => ({ id_producto: item.id_producto, cantidad: item.quantity }));
        const response = await fetch(`${baseUrl}/index.php?route=api/saveCart`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ items })
        });
        const data = await response.json();
        toast(data.message || 'Carrito guardado.');
    }

    // Función AJAX para procesar el checkout en el backend
    async function checkout() {
        const items = getCart().map((item) => ({ id_producto: item.id_producto, cantidad: item.quantity }));
        if (!items.length) {
            toast('Tu carrito está vacío.');
            return;
        }

        const response = await fetch(`${baseUrl}/index.php?route=api/checkout`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ items })
        });
        const data = await response.json();
        toast(data.message || 'Proceso completado.');
        if (data.ok) {
            setCart([]);
            renderCart();
        }
    }

     // Delegación de eventos para botones de agregar y acciones dentro del carrito 
    document.addEventListener('click', (event) => {
        const addBtn = event.target.closest('.add-to-cart-btn');
        if (addBtn) {
            addToCart(addBtn);
        }

        const actionBtn = event.target.closest('[data-action]');
        if (actionBtn) {
            updateCart(actionBtn.dataset.action, actionBtn.dataset.id);
        }
    });

    // Manejo del formulario de filtros
    filterForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        fetchProducts(Object.fromEntries(new FormData(filterForm).entries()));
    });

    resetFilters?.addEventListener('click', () => setTimeout(() => fetchProducts({}), 0));
    saveCartBtn?.addEventListener('click', saveCartRemote);
    checkoutBtn?.addEventListener('click', checkout);

    renderCart();
})();
