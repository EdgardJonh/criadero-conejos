@extends('layouts.conejos')

@section('content')
<div class="container">
    <h1>Editar Conejo</h1>
    <form action="{{ route('conejos.update', $conejo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $conejo->nombre) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Principal Actual</label><br>
            <img src="{{ asset('storage/' . $conejo->foto_principal) }}" width="100" alt="Foto principal">
        </div>
        <div class="mb-3">
            <label for="foto_principal" class="form-label">Cambiar Foto Principal</label>
            <input type="file" name="foto_principal" class="form-control" accept="image/*">
            <small class="form-text text-muted">Máximo 1MB. Formatos: JPG, PNG</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Fotos Adicionales Actuales</label><br>
            <div id="fotos-guardadas" class="d-flex flex-wrap gap-2 mb-2">
            @if($conejo->fotos_adicionales)
                @foreach($conejo->fotos_adicionales as $idx => $foto)
                    <div class="position-relative" style="width:100px;height:100px;">
                        <img src="{{ asset('storage/' . $foto) }}" width="80" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;" alt="Foto adicional">
                        <button type="button" class="btn-close position-absolute top-0 end-0 btn-delete-guardada" data-foto="{{ $foto }}" style="background:white;"></button>
                    </div>
                @endforeach
            @else
                <span>No hay fotos adicionales.</span>
            @endif
            </div>
        </div>
        <div class="mb-3">
            <label for="fotos_adicionales" class="form-label">Cambiar Fotos Adicionales</label>
            <div class="d-flex flex-wrap gap-2 mb-2" id="preview-fotos-adicionales"></div>
            <input type="file" id="fotos_adicionales_input" accept="image/*" style="display:none;" multiple>
            <button type="button" class="btn btn-secondary" id="agregar-fotos-btn">Agregar más fotos</button>
            <small class="form-text text-muted d-block mt-2">Máximo 1MB por imagen. Formatos: JPG, PNG</small>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" value="{{ old('numero', $conejo->numero) }}" required>
        </div>
        <div class="mb-3">
            <label for="raza" class="form-label">Raza</label>
            <select name="raza" class="form-control" required>
                <option value="">Seleccione una raza</option>
                <option value="Mini Lop" {{ old('raza', $conejo->raza) == 'Mini Lop' ? 'selected' : '' }}>Mini Lop</option>
                <option value="Holland Lop" {{ old('raza', $conejo->raza) == 'Holland Lop' ? 'selected' : '' }}>Holland Lop</option>
                <option value="Fuzzy Lop" {{ old('raza', $conejo->raza) == 'Fuzzy Lop' ? 'selected' : '' }}>Fuzzy Lop</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" name="color" class="form-control" value="{{ old('color', $conejo->color) }}">
        </div>
        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select name="sexo" class="form-control">
                <option value="">Seleccione sexo</option>
                <option value="Macho" {{ old('sexo', $conejo->sexo) == 'Macho' ? 'selected' : '' }}>Macho</option>
                <option value="Hembra" {{ old('sexo', $conejo->sexo) == 'Hembra' ? 'selected' : '' }}>Hembra</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $conejo->fecha_nacimiento ? $conejo->fecha_nacimiento->format('Y-m-d') : '') }}">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $conejo->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', $conejo->precio) }}" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponible" class="form-check-input" id="disponible" {{ old('disponible', $conejo->disponible) ? 'checked' : '' }}>
            <label class="form-check-label" for="disponible">Disponible</label>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
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
            let oldInput = document.getElementById('fotos_adicionales_hidden');
            if (oldInput) oldInput.remove();
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

        // Eliminar foto guardada
        document.querySelectorAll('.btn-delete-guardada').forEach(btn => {
            btn.addEventListener('click', function() {
                const foto = this.getAttribute('data-foto');
                if(confirm('¿Seguro que deseas eliminar esta foto?')) {
                    fetch(`{{ url('conejos') }}/{{ $conejo->id }}/delete-foto`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ foto })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            this.parentElement.remove();
                        } else {
                            alert('No se pudo eliminar la foto.');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection 