@extends('layouts.conejos')

@section('content')
<div class="container">
    <h1>Nuevo Conejo</h1>
    <form action="{{ route('conejos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>
        <div class="mb-3">
            <label for="foto_principal" class="form-label">Foto Principal</label>
            <input type="file" name="foto_principal" class="form-control" accept="image/*" required>
            <small class="form-text text-muted">Máximo 1MB. Formatos: JPG, PNG</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Fotos Adicionales</label>
            <div class="d-flex flex-wrap gap-2 mb-2" id="preview-fotos-adicionales"></div>
            <input type="file" id="fotos_adicionales_input" accept="image/*" style="display:none;" multiple>
            <button type="button" class="btn btn-secondary" id="agregar-fotos-btn">Agregar más fotos</button>
            <small class="form-text text-muted d-block mt-2">Máximo 1MB por imagen. Formatos: JPG, PNG</small>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" value="{{ old('numero', 'C' . rand(1000, 9999)) }}" required>
        </div>
        <div class="mb-3">
            <label for="raza" class="form-label">Raza</label>
            <select name="raza" class="form-control" required>
                <option value="">Seleccione una raza</option>
                <option value="Mini Lop" {{ old('raza') == 'Mini Lop' ? 'selected' : '' }}>Mini Lop</option>
                <option value="Holland Lop" {{ old('raza') == 'Holland Lop' ? 'selected' : '' }}>Holland Lop</option>
                <option value="Fuzzy Lop" {{ old('raza') == 'Fuzzy Lop' ? 'selected' : '' }}>Fuzzy Lop</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" name="color" class="form-control" value="{{ old('color') }}">
        </div>
        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select name="sexo" class="form-control">
                <option value="">Seleccione sexo</option>
                <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponible" class="form-check-input" id="disponible" {{ old('disponible') ? 'checked' : '' }}>
            <label class="form-check-label" for="disponible">Disponible</label>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('conejos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('fotos_adicionales_input');
        const preview = document.getElementById('preview-fotos-adicionales');
        const addBtn = document.getElementById('agregar-fotos-btn');
        const form = document.querySelector('form');
        let filesArray = [];

        addBtn.addEventListener('click', function() {
            input.click();
        });

        input.addEventListener('change', function(e) {
            for (let file of Array.from(e.target.files)) {
                if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                    filesArray.push(file);
                }
            }
            renderPreviews();
            input.value = '';
        });

        function renderPreviews() {
            preview.innerHTML = '';
            filesArray.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.style.width = '100px';
                    div.style.height = '100px';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">
                        <button type="button" class="btn-close position-absolute top-0 end-0" aria-label="Eliminar" data-idx="${idx}" style="background:white;"></button>
                    `;
                    div.querySelector('button').onclick = function() {
                        filesArray.splice(idx, 1);
                        renderPreviews();
                    };
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        // Al enviar el formulario, agregamos los archivos a un input file oculto
        form.addEventListener('submit', function(e) {
            // Elimina el input file anterior si existe
            let oldInput = document.getElementById('fotos_adicionales_hidden');
            if (oldInput) oldInput.remove();
            // Crea un nuevo input file
            const dataTransfer = new DataTransfer();
            filesArray.forEach(file => dataTransfer.items.add(file));
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'file';
            hiddenInput.name = 'fotos_adicionales[]';
            hiddenInput.multiple = true;
            hiddenInput.style.display = 'none';
            hiddenInput.id = 'fotos_adicionales_hidden';
            hiddenInput.files = dataTransfer.files;
            form.appendChild(hiddenInput);
        });
    });
</script>
@endsection 