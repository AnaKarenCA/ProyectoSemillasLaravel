document.addEventListener("DOMContentLoaded", () => {
    // ==== 1. Fecha y hora ====
    function updateDateTime() {
        const now = new Date();
        document.getElementById("date-field").textContent =
            now.toLocaleDateString("es-MX");
        document.getElementById("time-field").textContent =
            now.toLocaleTimeString("es-MX");
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

    let carrito = [];

    // ==== 3. Renderizar productos disponibles ====
    function renderProductos(list = productos) {
        tableBody.innerHTML = "";
        const limitados = list.slice(0, 3); // Limitar a 5 resultados
        limitados.forEach((prod) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${prod.nombre}</td>
                <td>$${parseFloat(prod.precio).toFixed(2)}</td>
                <td>${prod.stock}</td>
                <td>
                    <button class="btn btn-sm btn-success add-btn" data-id="${prod.id_producto}" ${prod.stock <= 0 ? 'disabled' : ''}>
                        <span class="material-symbols-outlined">add_shopping_cart</span>
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }
    renderProductos();

    // ==== 4. Filtros ====
    const categoryFilter = document.getElementById("category-filter");
    const priceFilter = document.getElementById("price-filter");
    const priceManual = document.getElementById("price-manual");
    const sliderValue = document.getElementById("slider-value");

    function filterProductos() {
        let texto = searchInput.value.toLowerCase();
        let categoria = categoryFilter.value;
        let precioMax = parseFloat(priceFilter.value);

        sliderValue.textContent = precioMax;

        const filtrados = productos.filter((p) => {
            let matchNombre = p.nombre.toLowerCase().includes(texto);
            let matchCategoria = categoria ? p.categoria_id == categoria : true;
            let matchPrecio = p.precio <= precioMax;
            return matchNombre && matchCategoria && matchPrecio;
        });

        renderProductos(filtrados);
    }

    searchInput.addEventListener("input", filterProductos);
    categoryFilter.addEventListener("change", filterProductos);
    priceFilter.addEventListener("input", filterProductos);
    priceManual.addEventListener("keyup", () => {
        let val = parseFloat(priceManual.value);
        if (!isNaN(val)) {
            priceFilter.value = val;
            filterProductos();
        }
    });

    // ==== 5. Escaneo de código de barras o QR ====
    const barcodeInput = document.createElement("input");
    barcodeInput.type = "text";
    barcodeInput.id = "barcode-input";
    barcodeInput.placeholder = "Escanea código o QR aquí...";
    barcodeInput.classList.add("form-control", "mt-2", "w-50");
    document.querySelector(".search-section").appendChild(barcodeInput);

    let scanTimeout;
    barcodeInput.addEventListener("input", (e) => {
        clearTimeout(scanTimeout);
        scanTimeout = setTimeout(() => {
            const code = e.target.value.trim();
            if (code.length > 0) buscarPorCodigo(code);
            e.target.value = "";
        }, 400); // espera breve por si el lector manda rápido los caracteres
    });

    function buscarPorCodigo(code) {
        const producto = productos.find(p =>
            p.codigo === code || p.id_producto.toString() === code
        );

        if (producto) {
            agregarProducto(producto.id_producto);
        } else {
            alert("⚠️ Producto no encontrado para el código: " + code);
        }
    }

    // ==== 6. Agregar/Quitar productos ====
    document.addEventListener("click", (e) => {
        if (e.target.closest(".add-btn")) {
            const id = e.target.closest(".add-btn").dataset.id;
            agregarProducto(id);
        }

        if (e.target.classList.contains("remove-btn")) {
            const id = e.target.dataset.id;
            carrito = carrito.filter((i) => i.id != id);
            renderCarrito();
        }
    });

    function agregarProducto(id) {
        const producto = productos.find((p) => p.id_producto == id);
        if (!producto) return;

        let item = carrito.find((i) => i.id == id);

        if (item) {
            if (item.cantidad < producto.stock) {
                item.cantidad++;
            } else {
                alert('No puedes agregar más unidades, no hay suficiente stock.');
                return;
            }
        } else {
            if (producto.stock <= 0) {
                alert('Este producto no tiene stock disponible.');
                return;
            }
            carrito.push({
                id: producto.id_producto,
                nombre: producto.nombre,
                precio: parseFloat(producto.precio),
                cantidad: 1,
                stock: producto.stock
            });
        }

        renderCarrito();
    }

    // ==== 7. Renderizar carrito ====
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
                           min="1" 
                           max="${item.stock}" 
                           value="${item.cantidad}" 
                           class="cantidad-input form-control form-control-sm" 
                           data-id="${item.id}">
                </td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>$${subtotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger remove-btn" data-id="${item.id}">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </td>
            `;
            saleBody.appendChild(tr);
        });

        totalField.textContent = total.toFixed(2);
        calcularCambio();
    }

    // ==== 8. Actualizar cantidades ====
    document.addEventListener("input", (e) => {
        if (e.target.classList.contains("cantidad-input")) {
            const id = e.target.dataset.id;
            let nuevaCantidad = parseInt(e.target.value);

            carrito = carrito.map((item) => 
                item.id == id
                    ? { ...item, cantidad: Math.max(1, Math.min(nuevaCantidad, item.stock)) }
                    : item
            );
            renderCarrito();
        }
    });

    // ==== 9. Calcular cambio ====
    cambioInput.addEventListener("keyup", calcularCambio);

    function calcularCambio() {
        const pago = parseFloat(cambioInput.value) || 0;
        const total = parseFloat(totalField.textContent) || 0;
        const cambio = pago - total;
        changeTotal.textContent = cambio >= 0 ? cambio.toFixed(2) : "0.00";
    }

    // ==== 10. Guardar venta ====
    document.getElementById("realizar-venta-btn").addEventListener("click", () => {
        if (carrito.length === 0) {
            alert("No hay productos en la venta");
            return;
        }

        const total = parseFloat(totalField.textContent);
        const data = {
            venta_data: carrito.map((i) => ({
                id: i.id,
                cantidad: i.cantidad,
                precio: i.precio,
            })),
            total: total,
        };

        fetch("/venta", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify(data),
        })
        .then((res) => res.json())
        .then((res) => {
            if (res.success) {
                alert(res.message);

                // Actualiza stock local
                res.productos.forEach(item => {
                    let prod = productos.find(p => p.id_producto === item.id_producto);
                    if (prod) prod.stock = item.stock;
                });

                carrito = [];
                renderCarrito();
                renderProductos();
            } else {
                alert(res.message);
            }
        })
        .catch((err) => console.error(err));
    });
});
