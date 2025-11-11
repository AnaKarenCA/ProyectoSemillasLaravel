@csrf
@if(isset($proveedor))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" 
           value="{{ old('nombre', $proveedor->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" name="telefono" class="form-control"
           value="{{ old('telefono', $proveedor->telefono ?? '') }}">
</div>

<div class="mb-3">
    <label for="correo" class="form-label">Correo</label>
    <input type="email" name="correo" class="form-control"
           value="{{ old('correo', $proveedor->correo ?? '') }}">
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <textarea name="direccion" class="form-control">{{ old('direccion', $proveedor->direccion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <select name="estado" class="form-select">
        <option value="Activo" {{ (old('estado', $proveedor->estado ?? '') == 'Activo') ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ (old('estado', $proveedor->estado ?? '') == 'Inactivo') ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>

<button type="submit" class="btn btn-primary">
    {{ isset($proveedor) ? 'Actualizar' : 'Guardar' }}
</button>
<a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
