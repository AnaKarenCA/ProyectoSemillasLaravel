@if($datos->isEmpty())
<p>No hay resultados para los filtros seleccionados.</p>
@else
<table border="1" style="width:100%;border-collapse:collapse;">
    <thead>
        <tr>
            @if($filtro=="productos_mas_vendidos")
            <th>Producto</th><th>Total Vendido</th>
            @elseif($filtro=="bajo_stock")
            <th>Producto</th><th>Stock</th>
            @elseif($filtro=="ventas_usuario")
            <th>ID Venta</th><th>Producto</th><th>Cantidad</th><th>Usuario</th><th>Fecha</th>
            @elseif($filtro=="ventas_categoria")
            <th>ID Venta</th><th>Producto</th><th>Cantidad</th><th>Usuario</th><th>Categoría</th><th>Fecha</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $row)
        <tr>
            @if($filtro=="productos_mas_vendidos")
            <td>{{ $row->nombre }}</td>
            <td>{{ $row->total_vendido }}</td>
            @elseif($filtro=="bajo_stock")
            <td>{{ $row->nombre }}</td>
            <td>{{ $row->stock }}</td>
            @elseif($filtro=="ventas_usuario")
            <td>{{ $row->id_venta }}</td>
            <td>{{ $row->producto }}</td>
            <td>{{ $row->cantidad }}</td>
            <td>{{ $row->nombre_usuario }}</td>
            <td>{{ $row->fecha }}</td>
            @elseif($filtro=="ventas_categoria")
            <td>{{ $row->id_venta }}</td>
            <td>{{ $row->producto }}</td>
            <td>{{ $row->cantidad }}</td>
            <td>{{ $row->nombre_usuario }}</td>
            <td>{{ $row->nombre_categoria }}</td>
            <td>{{ $row->fecha }}</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endif
