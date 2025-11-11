@extends('layouts.app')

@section('title', 'Registrar Compra')

@section('content')
<section class="hero-section py-5 text-center text-white">
    <h1 class="display-5 fw-bold">Registrar Nueva Compra</h1>
</section>

<div class="container my-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas con los datos.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <form action="{{ route('compras.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Proveedor</label>
                        <select name="id_proveedor" class="form-select" required>
                            <option value="">Selecciona un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Folio / Factura</label>
                        <input type="text" name="folio_factura" class="form-control" placeholder="FAC-0001">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" value="{{ date('Y-m-d') }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Forma de pago</label>
                        <select name="forma_pago" class="form-select" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="crédito">Crédito</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado del pago</label>
                        <select name="estado_pago" class="form-select" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagada">Pagada</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Total (auto)</label>
                        <input type="number" step="0.01" name="total" id="total" class="form-control" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2" placeholder="Ej. Compra mensual de chiles y semillas"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2" placeholder="Notas adicionales o condiciones de pago"></textarea>
                </div>

                <hr>
                <h5 class="mb-3">
                    <span class="material-icons align-middle">shopping_cart</span> Detalle de productos
                </h5>

                <table class="table table-bordered" id="tablaProductos">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="detalle-productos">
                        <tr>
                            <td>
                                <select name="productos[0][id_producto]" class="form-select producto-select" required>
                                    <option value="">Selecciona un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id_producto }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="productos[0][cantidad]" class="form-control cantidad" min="1" value="1" required></td>
                            <td><input type="number" step="0.01" name="productos[0][costo]" class="form-control costo" required></td>
                            <td class="subtotal">0.00</td>
                            <td><button type="button" class="btn btn-danger btn-sm eliminar-fila"><span class="material-icons">delete</span></button></td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-end mb-3">
                    <button type="button" id="agregarFila" class="btn btn-agregar">
                        <span class="material-icons align-middle">add_circle</span> Agregar producto
                    </button>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-guardar me-2">
                        <span class="material-icons align-middle">save</span> Guardar Compra
                    </button>
                    <a href="{{ route('compras.index') }}" class="btn btn-cancelar">
                        <span class="material-icons align-middle">arrow_back</span> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
body {
    background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
    background-size: cover;
}
.hero-section {
    background-color: #800000;
}
.btn-guardar, .btn-agregar {
    background-color: #ce0202c3;
    color: white;
    transition: 0.3s;
}
.btn-guardar:hover, .btn-agregar:hover {
    background-color: #800000;
    transform: scale(1.05);
}
.btn-cancelar {
    background-color: #555;
    color: white;
}
.btn-cancelar:hover {
    background-color: #333;
}
.card {
    border-radius: 15px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const detalleBody = document.getElementById('detalle-productos');
    const agregarFila = document.getElementById('agregarFila');
    const totalInput = document.getElementById('total');
    let filaIndex = 1;

    function recalcularTotales() {
        let total = 0;
        detalleBody.querySelectorAll('tr').forEach(tr => {
            const cantidad = parseFloat(tr.querySelector('.cantidad')?.value || 0);
            const costo = parseFloat(tr.querySelector('.costo')?.value || 0);
            const subtotal = cantidad * costo;
            tr.querySelector('.subtotal').innerText = subtotal.toFixed(2);
            total += subtotal;
        });
        totalInput.value = total.toFixed(2);
    }

    agregarFila.addEventListener('click', () => {
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td>
                <select name="productos[${filaIndex}][id_producto]" class="form-select producto-select" required>
                    <option value="">Selecciona un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id_producto }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="productos[${filaIndex}][cantidad]" class="form-control cantidad" min="1" value="1" required></td>
            <td><input type="number" step="0.01" name="productos[${filaIndex}][costo]" class="form-control costo" required></td>
            <td class="subtotal">0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm eliminar-fila"><span class="material-icons">delete</span></button></td>
        `;
        detalleBody.appendChild(nuevaFila);
        filaIndex++;
    });

    detalleBody.addEventListener('input', e => {
        if (e.target.classList.contains('cantidad') || e.target.classList.contains('costo')) {
            recalcularTotales();
        }
    });

    detalleBody.addEventListener('click', e => {
        if (e.target.closest('.eliminar-fila')) {
            e.target.closest('tr').remove();
            recalcularTotales();
        }
    });
});
</script>
@endsection
