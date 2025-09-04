@extends('layouts.conejos')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Editar Conejo</h1>
    </div>
    
    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <form action="{{ route('conejos.update', $conejo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="col-span-1">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror" value="{{ old('nombre', $conejo->nombre) }}" required>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Número -->
                <div class="col-span-1">
                    <label for="numero" class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                    <input type="text" name="numero" id="numero" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('numero') border-red-500 @enderror" value="{{ old('numero', $conejo->numero) }}" required>
                    @error('numero')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Foto Principal Actual -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Principal Actual</label>
                    <img src="{{ asset('storage/' . $conejo->foto_principal) }}" class="h-32 w-32 object-cover rounded-md" alt="Foto principal">
                </div>
                
                <!-- Cambiar Foto Principal -->
                <div class="col-span-1">
                    <label for="foto_principal" class="block text-sm font-medium text-gray-700 mb-1">Cambiar Foto Principal</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200" id="foto_principal_dropzone">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" id="foto_principal_icon">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="foto_principal" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Cambiar foto</span>
                                    <input id="foto_principal" name="foto_principal" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG hasta 1MB</p>
                        </div>
                    </div>
                    
                    <!-- Preview de nueva foto principal -->
                    <div id="foto_principal_preview" class="mt-3 hidden">
                        <img id="foto_principal_img" class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200" alt="Preview">
                        <button type="button" id="remove_foto_principal" class="mt-2 text-sm text-red-600 hover:text-red-800">Remover nueva foto</button>
                    </div>
                    @error('foto_principal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200" id="fotos_adicionales_dropzone">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" id="fotos_adicionales_icon">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="fotos_adicionales_input" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Agregar fotos</span>
                                    <input id="fotos_adicionales_input" name="fotos_adicionales[]" type="file" class="sr-only" accept="image/*" multiple>
                                </label>
                                <p class="pl-1">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG hasta 1MB cada una</p>
                        </div>
                    </div>
                    
                    <!-- Preview de fotos adicionales -->
                    <div id="preview-fotos-adicionales" class="mt-3 grid grid-cols-4 gap-2"></div>
                    
                    <!-- Botón para agregar fotos -->
                    <button type="button" id="agregar-fotos-btn" class="mt-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Agregar más fotos
                    </button>
                    
                    <!-- Input oculto para enviar las fotos adicionales -->
                    <input type="hidden" name="fotos_adicionales_json" id="fotos_adicionales_json">
                    @error('fotos_adicionales.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Raza -->
                <div class="col-span-1">
                    <label for="raza" class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                    <select name="raza" id="raza" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('raza') border-red-500 @enderror" required>
                        <option value="">Seleccione una raza</option>
                        <option value="Mini Lop" {{ old('raza', $conejo->raza) == 'Mini Lop' ? 'selected' : '' }}>Mini Lop</option>
                        <option value="Holland Lop" {{ old('raza', $conejo->raza) == 'Holland Lop' ? 'selected' : '' }}>Holland Lop</option>
                        <option value="Fuzzy Lop" {{ old('raza', $conejo->raza) == 'Fuzzy Lop' ? 'selected' : '' }}>Fuzzy Lop</option>
                        <option value="Angora" {{ old('raza', $conejo->raza) == 'Angora' ? 'selected' : '' }}>Angora</option>
                        <option value="Rex" {{ old('raza', $conejo->raza) == 'Rex' ? 'selected' : '' }}>Rex</option>
                        <option value="Holandés Enano" {{ old('raza', $conejo->raza) == 'Holandés Enano' ? 'selected' : '' }}>Holandés Enano</option>
                    </select>
                    @error('raza')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                    @error('fecha_nacimiento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Precio -->
                <div class="col-span-1">
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio (CLP) *</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" 
                               step="1" 
                               min="0" 
                               max="999999999"
                               name="precio" 
                               id="precio" 
                               class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('precio') border-red-500 @enderror" 
                               value="{{ old('precio', (int)$conejo->precio) }}" 
                               required 
                               placeholder="15000">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Precio en pesos chilenos (sin decimales, máximo 999,999,999)</p>
                    @error('precio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Disponible -->
                <div class="col-span-1">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="disponible" 
                               id="disponible" 
                               value="1"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
                               {{ old('disponible', $conejo->disponible) ? 'checked' : '' }}>
                        <label for="disponible" class="ml-2 block text-sm text-gray-700">Disponible</label>
                    </div>
                </div>
            </div>
            
            <!-- Descripción -->
            <div class="mt-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $conejo->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
        // Elementos del DOM para foto principal
        const fotoPrincipalInput = document.getElementById('foto_principal');
        const fotoPrincipalPreview = document.getElementById('foto_principal_preview');
        const fotoPrincipalImg = document.getElementById('foto_principal_img');
        const fotoPrincipalIcon = document.getElementById('foto_principal_icon');
        const removeFotoPrincipalBtn = document.getElementById('remove_foto_principal');
        const fotoPrincipalDropzone = document.getElementById('foto_principal_dropzone');
        
        // Elementos del DOM para fotos adicionales
        const fotosAdicionalesInput = document.getElementById('fotos_adicionales_input');
        const previewFotosAdicionales = document.getElementById('preview-fotos-adicionales');
        const addBtn = document.getElementById('agregar-fotos-btn');
        const form = document.querySelector('form');
        let filesArray = [];

        // Función para mostrar preview de foto principal
        function showFotoPrincipalPreview(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoPrincipalImg.src = e.target.result;
                    fotoPrincipalPreview.classList.remove('hidden');
                    fotoPrincipalIcon.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Función para ocultar preview de foto principal
        function hideFotoPrincipalPreview() {
            fotoPrincipalPreview.classList.add('hidden');
            fotoPrincipalIcon.classList.remove('hidden');
            fotoPrincipalInput.value = '';
        }
        
        // Event listener para foto principal
        fotoPrincipalInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                showFotoPrincipalPreview(file);
            }
        });
        
        // Botón para remover foto principal
        removeFotoPrincipalBtn.addEventListener('click', function() {
            hideFotoPrincipalPreview();
        });
        
        // Drag and drop para foto principal
        fotoPrincipalDropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            fotoPrincipalDropzone.classList.add('border-indigo-400', 'bg-indigo-50');
        });
        
        fotoPrincipalDropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fotoPrincipalDropzone.classList.remove('border-indigo-400', 'bg-indigo-50');
        });
        
        fotoPrincipalDropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            fotoPrincipalDropzone.classList.remove('border-indigo-400', 'bg-indigo-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    fotoPrincipalInput.files = files;
                    showFotoPrincipalPreview(file);
                }
            }
        });

        // Funcionalidad para fotos adicionales
        addBtn.addEventListener('click', function() {
            fotosAdicionalesInput.click();
        });

        fotosAdicionalesInput.addEventListener('change', function(e) {
            for (let file of Array.from(e.target.files)) {
                if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                    filesArray.push(file);
                }
            }
            renderPreviews();
            fotosAdicionalesInput.value = '';
        });

        function renderPreviews() {
            previewFotosAdicionales.innerHTML = '';
            filesArray.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <div class="w-24 h-24 relative">
                            <img src="${e.target.result}" class="w-24 h-24 rounded-md object-cover border-2 border-gray-200">
                            <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200" onclick="removeFotoAdicional(${idx})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    `;
                    previewFotosAdicionales.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        // Función global para remover foto adicional
        window.removeFotoAdicional = function(index) {
            filesArray.splice(index, 1);
            renderPreviews();
        };

        // Drag and drop para fotos adicionales
        const fotosAdicionalesDropzone = document.getElementById('fotos_adicionales_dropzone');
        
        fotosAdicionalesDropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            fotosAdicionalesDropzone.classList.add('border-indigo-400', 'bg-indigo-50');
        });
        
        fotosAdicionalesDropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fotosAdicionalesDropzone.classList.remove('border-indigo-400', 'bg-indigo-50');
        });
        
        fotosAdicionalesDropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            fotosAdicionalesDropzone.classList.remove('border-indigo-400', 'bg-indigo-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fotosAdicionalesInput.files = files;
                for (let file of Array.from(files)) {
                    if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                        filesArray.push(file);
                    }
                }
                renderPreviews();
            }
        });

        // Al enviar el formulario, agregamos los archivos a un input file oculto
        form.addEventListener('submit', function(e) {
            // Validar campos requeridos
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            // Validación específica para el precio
            const precioField = document.getElementById('precio');
            const precio = parseInt(precioField.value);
            
            if (isNaN(precio) || precio < 0 || precio > 999999999) {
                precioField.classList.add('border-red-500');
                isValid = false;
                alert('El precio debe ser un número entero entre 0 y 999,999,999 pesos chilenos.');
            } else {
                precioField.classList.remove('border-red-500');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, completa todos los campos obligatorios correctamente.');
                return;
            }
            
            // Crear input oculto para fotos adicionales
            let oldInput = document.getElementById('fotos_adicionales_hidden');
            if (oldInput) oldInput.remove();
            
            if (filesArray.length > 0) {
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
            }
            
            console.log('Formulario enviado correctamente');
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

        // Validación en tiempo real para el campo precio
        const precioField = document.getElementById('precio');
        precioField.addEventListener('input', function() {
            const value = this.value;
            const precio = parseInt(value);
            
            if (value === '') {
                this.classList.remove('border-red-500');
                return;
            }
            
            if (isNaN(precio) || precio < 0 || precio > 999999999) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });
        
        // Debug del checkbox disponible
        const disponibleCheckbox = document.getElementById('disponible');
        disponibleCheckbox.addEventListener('change', function() {
            console.log('Checkbox disponible cambiado:', this.checked);
            console.log('Valor del checkbox:', this.value);
        });
        
        console.log('Formulario de edición de conejos cargado correctamente');
        console.log('Estado inicial del checkbox disponible:', disponibleCheckbox.checked);
    });
</script>
@endsection