<div class="mb-3">
    <label>Nombre:</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Apellido Paterno:</label>
    <input type="text" name="apellido_paterno" class="form-control" value="{{ old('apellido_paterno', $cliente->apellido_paterno ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Apellido Materno:</label>
    <input type="text" name="apellido_materno" class="form-control" value="{{ old('apellido_materno', $cliente->apellido_materno ?? '') }}">
</div>
<div class="mb-3">
    <label>Correo Electrónico:</label>
    <input type="email" name="correo" class="form-control" value="{{ old('correo', $cliente->correo ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Teléfono:</label>
    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono ?? '') }}">
</div>
<div class="mb-3">
    <label>Dirección:</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion ?? '') }}">
</div>
<div class="mb-3">
    <label>Descuento (%):</label>
    <input type="number" name="descuento" class="form-control" min="0" max="100" step="0.01" value="{{ old('descuento', $cliente->descuento ?? 0) }}">
</div>

@if(isset($cliente))
<div class="mb-3">
    <label>Estado:</label>
    <select name="estado" class="form-select">
        <option value="activo" {{ $cliente->estado == 'activo' ? 'selected' : '' }}>Activo</option>
        <option value="inactivo" {{ $cliente->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>
@endif
