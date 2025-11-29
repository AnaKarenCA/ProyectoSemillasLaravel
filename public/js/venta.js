document.addEventListener("DOMContentLoaded", () => {

    // ==== 1. Fecha y hora ====
    function updateDateTime() {
        const now = new Date();
        document.getElementById("date-field").textContent = now.toLocaleDateString("es-MX");
        document.getElementById("time-field").textContent = now.toLocaleTimeString("es-MX");
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // ==== 2. Variables ====
    const productos = window.productosDisponibles || [];
    const tableBody = document.querySelector("#available-products-table tbody");
    const saleBody = document.querySelector("#sale-table tbody");
    const totalField = document.getElementById("purchase-total");
    const cambioInput = document.getElementById("cambio-input");
    const changeTotal = document.getElementById("change-total");
    const searchInput = document.getElementById("product-search");
    const categoryFilter = document.getElementById("category-filter");

    const barcodeInput = document.getElementById("codigo-barra-input");

    let carrito = [];

    // ===============================================================
    // 3. Renderizar productos disponibles
    // ===============================================================
    function renderProductos(list = productos) {
        tableBody.innerHTML = "";

        list.forEach((prod) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${prod.id_producto}</td>
                <td>${prod.nombre}</td>
                <td>${prod.base_unidad || ''}</td>
                <td>$${parseFloat(prod.precio).toFixed(2)}</td>
                <td>${prod.stock}</td>
                <td>
                    <button class="btn btn-sm btn-success add-btn" data-id="${prod.id_producto}" ${prod.stock <= 0 ? 'disabled' : ''}>
                        <span class="material-icons">add_shopping_cart</span>
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    renderProductos();


    // ===============================================================
    // 4. FILTRO POR NOMBRE (5 coincidencias máximas)
    // ===============================================================
    function filterProductos() {
        let texto = searchInput.value.trim().toLowerCase();
        let categoria = categoryFilter.value;

        let filtrados = productos.filter(p => {
            let matchNombre = p.nombre.toLowerCase().includes(texto);
            let matchCategoria = categoria ? p.id_categoria == categoria : true;
            return matchNombre && matchCategoria;
        });

        // limitar a 5 productos más relevantes
        filtrados = filtrados.slice(0, 5);

        renderProductos(filtrados);
    }

    searchInput.addEventListener("input", filterProductos);
    categoryFilter.addEventListener("change", filterProductos);


    // ===============================================================
    // 5. Lectura código de barras
    // ===============================================================
    let scanTimeout;

    barcodeInput.addEventListener("input", (e) => {
        clearTimeout(scanTimeout);

        scanTimeout = setTimeout(() => {
            const code = e.target.value.trim();
            if (code.length > 0) buscarPorCodigo(code);
            e.target.value = "";
        }, 350);
    });

    function buscarPorCodigo(code) {
        const producto = productos.find(p =>
            p.id_producto.toString() === code ||
            (p.codigo && p.codigo.toString() === code)
        );

        if (producto) agregarProducto(producto.id_producto);
        else alert("⚠️ Producto no encontrado");
    }


    // ===============================================================
    // 6. Agregar / eliminar del carrito
    // ===============================================================
    document.addEventListener("click", (e) => {

        if (e.target.closest(".add-btn")) {
            const id = e.target.closest(".add-btn").dataset.id;
            agregarProducto(id);
        }

        if (e.target.classList.contains("remove-btn")) {
            const id = e.target.dataset.id;
            carrito = carrito.filter(i => i.id != id);
            renderCarrito();
        }
    });

    function agregarProducto(id) {
        const producto = productos.find(p => p.id_producto == id);
        if (!producto) return;

        let item = carrito.find(i => i.id == id);

        if (item) {
            if (item.cantidad < producto.stock) item.cantidad++;
            else return alert("No hay suficiente stock disponible");
        } else {
            if (producto.stock <= 0) return alert("Producto sin stock");

            carrito.push({
                id: producto.id_producto,
                nombre: producto.nombre,
                precio: parseFloat(producto.precio),
                cantidad: 1,
                stock: producto.stock,
                unidad: producto.base_unidad
            });
        }

        renderCarrito();
    }


    // ===============================================================
    // 7. Render carrito
    // ===============================================================
    function renderCarrito() {
        saleBody.innerHTML = "";
        let total = 0;

        carrito.forEach((item) => {
            const subtotal = item.cantidad * item.precio;
            total += subtotal;

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${item.nombre}</td>

                <td>
                    <input type="number" 
                           min="1" max="${item.stock}" 
                           value="${item.cantidad}" 
                           class="cantidad-input form-control form-control-sm" 
                           data-id="${item.id}">
                </td>

                <td>${item.unidad || ''}</td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>$${subtotal.toFixed(2)}</td>

                <td>
                    <button class="btn btn-danger btn-sm remove-btn" data-id="${item.id}">
                        <span class="material-icons">delete</span>
                    </button>
                </td>
            `;

            saleBody.appendChild(tr);
        });

        totalField.textContent = total.toFixed(2);
        calcularCambio();
    }


    // ===============================================================
    // 8. Actualizar cantidades
    // ===============================================================
    document.addEventListener("input", (e) => {

        if (e.target.classList.contains("cantidad-input")) {

            const id = e.target.dataset.id;
            let nuevaCantidad = parseInt(e.target.value);

            carrito = carrito.map(item =>
                item.id == id
                    ? { ...item, cantidad: Math.max(1, Math.min(nuevaCantidad, item.stock)) }
                    : item
            );

            renderCarrito();
        }
    });


    // ===============================================================
    // 9. Calcular cambio
    // ===============================================================
    cambioInput.addEventListener("keyup", calcularCambio);

    function calcularCambio() {
        const pago = parseFloat(cambioInput.value) || 0;
        const total = parseFloat(totalField.textContent) || 0;

        let cambio = pago - total;
        changeTotal.textContent = cambio >= 0 ? cambio.toFixed(2) : "0.00";
    }


    // ===============================================================
    // 10. Guardar venta en BD
    // ===============================================================
    document.getElementById("realizar-venta-btn").addEventListener("click", () => {
        if (carrito.length === 0) return alert("⚠️ No hay productos en la venta");

        const total = parseFloat(totalField.textContent);

        const data = {
            venta_data: carrito.map(i => ({
                id: i.id,
                cantidad: i.cantidad,
                precio: i.precio
            })),
            total: total
        };

        fetch("/venta", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify(data),
        })
            .then(res => res.json())
            .then(res => {
                if (res.success) {

                    alert("Venta realizada correctamente");

                    // actualizar stock
                    res.productos.forEach(item => {
                        let prod = productos.find(p => p.id_producto == item.id_producto);
                        if (prod) prod.stock = item.stock;
                    });

                    carrito = [];
                    renderCarrito();
                    renderProductos();

                } else {
                    alert(res.message);
                }
            })
            .catch(err => console.error(err));
    });

});
