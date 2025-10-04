@extends('layouts.app')

@section('content')
<!-- Título con fondo rojo oscuro -->
<section style="background-color:#800000; color:#fff; text-align:center; padding:15px 0; margin-bottom:20px;">
    <h1 style="margin:0;">Reporte de Ventas</h1>
</section>

<!-- Formulario de filtros -->
<form id="formFiltros" style="display:flex;gap:10px;flex-wrap:wrap; justify-content:center; margin-bottom:15px;">
    <label>
        Filtro:
        <select name="filtro" id="filtro">
            <option value="productos_mas_vendidos">Productos Más Vendidos</option>
            <option value="bajo_stock">Productos Bajo Stock</option>
            <option value="ventas_usuario">Ventas por Usuario</option>
            <option value="ventas_categoria">Ventas por Categoría</option>
        </select>
    </label>

    <label>
        Usuario:
        <select name="usuario" id="usuario">
            <option value="">-- Todos --</option>
            @foreach($usuarios as $u)
            <option value="{{ $u->id_usuario }}">{{ $u->nombre }}</option>
            @endforeach
        </select>
    </label>

    <label>
        Categoría:
        <select name="categoria" id="categoria">
            <option value="">-- Todas --</option>
            @foreach($categorias as $c)
            <option value="{{ $c->id_categoria }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
    </label>

    <button type="button" onclick="generarReporte()" style="background:#800000;color:#fff;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;">Generar</button>
</form>

<!-- Botón de exportar a Excel -->
<!-- Botón de exportar a Excel centrado -->
<div style="text-align:center; margin-bottom:15px;">
    <button type="button" onclick="exportarExcelCliente()" style="background:#228B22;color:#fff;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;">
        Exportar a Excel
    </button>
</div>


<!-- Contenedor donde se mostrará el reporte -->
<div id="resultadoReporte"></div>

<!-- Scripts -->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function generarReporte() {
    const filtro = document.getElementById('filtro').value;
    const usuario = document.getElementById('usuario').value;
    const categoria = document.getElementById('categoria').value;

    fetch("{{ route('reportes.generar') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ filtro, usuario, categoria })
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('resultadoReporte').innerHTML = html;
    });
}

function exportarExcelCliente() {
    const table = document.querySelector("#resultadoReporte table");
    if (!table) return alert("Genera el reporte primero.");
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(table);
    XLSX.utils.book_append_sheet(wb, ws, "Reporte");
    XLSX.writeFile(wb, "reporte.xlsx");
}
</script>
@endsection
