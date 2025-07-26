@extends('layouts.conejos')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Editar Conejo</h1>
    </div>
    
    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('conejos.update', $conejo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="col-span-1">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('nombre', $conejo->nombre) }}" required>
                </div>
                
                <!-- Número -->
                <div class="col-span-1">
                    <label for="numero" class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                    <input type="text" name="numero" id="numero" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('numero', $conejo->numero) }}" required>
                </div>
                
                <!-- Foto Principal Actual -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Principal Actual</label>
                    <img src="{{ asset('storage/' . $conejo->foto_principal) }}" class="h-32 w-32 object-cover rounded-md" alt="Foto principal">
                </div>
                
                <!-- Cambiar Foto Principal -->
                <div class="col-span-1">
                    <label for="foto_principal" class="block text-sm font-medium text-gray-700 mb-1">Cambiar Foto Principal</label>
                    <input type="file" name="foto_principal" id="foto_principal" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                    <p class="mt-1 text-xs text-gray-500">Máximo 1MB. Formatos: JPG, PNG</p>
                </div>
                
                <!-- Fotos Adicionales Actuales -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fotos Adicionales Actuales</label>
                    <div id="fotos-guardadas" class="flex flex-wrap gap-2 mb-2">
                    @if($conejo->fotos_adicionales && count($conejo->fotos_adicionales) > 0)
                        @foreach($conejo->fotos_adicionales as $idx => $foto)
                            <div class="relative">
                                <div class="w-24 h-24 relative">
                                    <img src="{{ asset('storage/' . $foto) }}" class="w-24 h-24 rounded-md object-cover" alt="Foto adicional">
                                    <button type="button" class="absolute top-0 right-0 bg-white rounded-full p-1 shadow-sm hover:bg-gray-100 btn-delete-guardada" data-foto="{{ $foto }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">No hay fotos adicionales.</p>
                    @endif
                    </div>
                </div>
                
                <!-- Cambiar Fotos Adicionales -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agregar Fotos Adicionales</label>
                    <div class="flex flex-wrap gap-2 mb-2" id="preview-fotos-adicionales"></div>
                    <input type="file" id="fotos_adicionales_input" accept="image/*" class="hidden" multiple>
                    <button type="button" id="agregar-fotos-btn" class="mt-1 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Agregar más fotos
                    </button>
                    <p class="mt-1 text-xs text-gray-500">Máximo 1MB por imagen. Formatos: JPG, PNG</p>
                </div>
                
                <!-- Raza -->
                <div class="col-span-1">
                    <label for="raza" class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                    <select name="raza" id="raza" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Seleccione una raza</option>
                        <option value="Mini Lop" {{ old('raza', $conejo->raza) == 'Mini Lop' ? 'selected' : '' }}>Mini Lop</option>
                        <option value="Holland Lop" {{ old('raza', $conejo->raza) == 'Holland Lop' ? 'selected' : '' }}>Holland Lop</option>
                        <option value="Fuzzy Lop" {{ old('raza', $conejo->raza) == 'Fuzzy Lop' ? 'selected' : '' }}>Fuzzy Lop</option>
                    </select>
                </div>
                
                <!-- Color -->
                <div class="col-span-1">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="text" name="color" id="color" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('color', $conejo->color) }}">
                </div>
                
                <!-- Sexo -->
                <div class="col-span-1">
                    <label for="sexo" class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                    <select name="sexo" id="sexo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Seleccione sexo</option>
                        <option value="Macho" {{ old('sexo', $conejo->sexo) == 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Hembra" {{ old('sexo', $conejo->sexo) == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>
                
                <!-- Fecha de Nacimiento -->
                <div class="col-span-1">
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('fecha_nacimiento', $conejo->fecha_nacimiento ? $conejo->fecha_nacimiento->format('Y-m-d') : '') }}">
                </div>
                
                <!-- Precio -->
                <div class="col-span-1">
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" step="0.01" name="precio" id="precio" class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('precio', $conejo->precio) }}" required>
                    </div>
                </div>
                
                <!-- Disponible -->
                <div class="col-span-1">
                    <div class="flex items-center">
                        <input type="checkbox" name="disponible" id="disponible" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('disponible', $conejo->disponible) ? 'checked' : '' }}>
                        <label for="disponible" class="ml-2 block text-sm text-gray-700">Disponible</label>
                    </div>
                </div>
            </div>
            
            <!-- Descripción -->
            <div class="mt-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $conejo->descripcion) }}</textarea>
            </div>
            
            <!-- Botones -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('conejos.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Actualizar</button>
            </div>
        </form>
    </div>
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
                    div.className = 'relative';
                    div.innerHTML = `
                        <div class="w-24 h-24 relative">
                            <img src="${e.target.result}" class="w-24 h-24 rounded-md object-cover">
                            <button type="button" class="absolute top-0 right-0 bg-white rounded-full p-1 shadow-sm hover:bg-gray-100" aria-label="Eliminar" data-idx="${idx}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
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