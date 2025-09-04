@extends('layouts.conejos')

@section('content')
<div class="space-y-6">
    <!-- Header con título -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Nuevo Conejo</h1>
        <a href="{{ route('conejos.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a la lista
        </a>
    </div>
    
    <!-- Mensajes de error -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4" role="alert">
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

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <div class="bg-white shadow-lg rounded-xl border border-gray-200 p-8">
        <form action="{{ route('conejos.store') }}" method="POST" enctype="multipart/form-data" id="conejoForm">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="col-span-1">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('nombre') border-red-500 @enderror" 
                           value="{{ old('nombre') }}" 
                           required 
                           placeholder="Ej: Luna, Max, Bella">
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Número -->
                <div class="col-span-1">
                    <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">Número *</label>
                    <input type="text" 
                           name="numero" 
                           id="numero" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('numero') border-red-500 @enderror" 
                           value="{{ old('numero', 'C' . rand(1000, 9999)) }}" 
                           required 
                           placeholder="Ej: C001, C002">
                    @error('numero')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Foto Principal -->
                <div class="col-span-1">
                    <label for="foto_principal" class="block text-sm font-medium text-gray-700 mb-2">Foto Principal *</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200" id="foto_principal_dropzone">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" id="foto_principal_icon">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="foto_principal" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Subir foto</span>
                                    <input id="foto_principal" name="foto_principal" type="file" class="sr-only" accept="image/*" required>
                                </label>
                                <p class="pl-1">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG hasta 1MB</p>
                        </div>
                    </div>
                    <!-- Preview de foto principal -->
                    <div id="foto_principal_preview" class="mt-3 hidden">
                        <img id="foto_principal_img" class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200" alt="Preview">
                        <button type="button" id="remove_foto_principal" class="mt-2 text-sm text-red-600 hover:text-red-800">Remover foto</button>
                    </div>
                    @error('foto_principal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Fotos Adicionales -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fotos Adicionales</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200" id="fotos_adicionales_dropzone">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" id="fotos_adicionales_icon">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="fotos_adicionales" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Subir fotos</span>
                                    <input id="fotos_adicionales" name="fotos_adicionales[]" type="file" class="sr-only" accept="image/*" multiple>
                                </label>
                                <p class="pl-1">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG hasta 1MB cada una</p>
                        </div>
                    </div>
                    <!-- Preview de fotos adicionales -->
                    <div id="preview-fotos-adicionales" class="mt-3 grid grid-cols-4 gap-2"></div>
                    @error('fotos_adicionales.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Raza -->
                <div class="col-span-1">
                    <label for="raza" class="block text-sm font-medium text-gray-700 mb-2">Raza *</label>
                    <select name="raza" 
                            id="raza" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('raza') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione una raza</option>
                        <option value="Mini Lop" {{ old('raza') == 'Mini Lop' ? 'selected' : '' }}>Mini Lop</option>
                        <option value="Holland Lop" {{ old('raza') == 'Holland Lop' ? 'selected' : '' }}>Holland Lop</option>
                        <option value="Fuzzy Lop" {{ old('raza') == 'Fuzzy Lop' ? 'selected' : '' }}>Fuzzy Lop</option>
                        <option value="Angora" {{ old('raza') == 'Angora' ? 'selected' : '' }}>Angora</option>
                        <option value="Rex" {{ old('raza') == 'Rex' ? 'selected' : '' }}>Rex</option>
                        <option value="Holandés Enano" {{ old('raza') == 'Holandés Enano' ? 'selected' : '' }}>Holandés Enano</option>
                    </select>
                    @error('raza')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Color -->
                <div class="col-span-1">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                    <input type="text" 
                           name="color" 
                           id="color" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('color') border-red-500 @enderror" 
                           value="{{ old('color') }}" 
                           placeholder="Ej: Blanco, Negro, Gris, Marrón">
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Sexo -->
                <div class="col-span-1">
                    <label for="sexo" class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                    <select name="sexo" 
                            id="sexo" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('sexo') border-red-500 @enderror">
                        <option value="">Seleccione sexo</option>
                        <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                    @error('sexo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Fecha de Nacimiento -->
                <div class="col-span-1">
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento</label>
                    <input type="date" 
                           name="fecha_nacimiento" 
                           id="fecha_nacimiento" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('fecha_nacimiento') border-red-500 @enderror" 
                           value="{{ old('fecha_nacimiento') }}">
                    @error('fecha_nacimiento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Precio -->
                <div class="col-span-1">
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-2">Precio (CLP) *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" 
                               step="1" 
                               min="0"
                               name="precio" 
                               id="precio" 
                               class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('precio') border-red-500 @enderror" 
                               value="{{ old('precio') }}" 
                               required 
                               placeholder="15000">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Precio en pesos chilenos (sin decimales)</p>
                    @error('precio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Disponible -->
                <div class="col-span-1">
                    <div class="flex items-center h-full">
                        <input type="checkbox" 
                               name="disponible" 
                               id="disponible" 
                               value="1"
                               class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
                               {{ old('disponible', '1') == '1' ? 'checked' : '' }}>
                        <label for="disponible" class="ml-3 block text-sm text-gray-700">Disponible para venta</label>
                    </div>
                    <!-- Campo oculto para asegurar que siempre se envíe un valor -->
                    <input type="hidden" name="disponible" value="0">
                </div>
            </div>
            
            <!-- Descripción -->
            <div class="mt-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="descripcion" 
                          id="descripcion" 
                          rows="4" 
                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('descripcion') border-red-500 @enderror" 
                          placeholder="Describe las características del conejo, su personalidad, etc.">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Botones -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('conejos.index') }}" 
                   class="inline-flex justify-center py-3 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar Conejo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
        const fotoPrincipalInput = document.getElementById('foto_principal');
        const fotoPrincipalPreview = document.getElementById('foto_principal_preview');
        const fotoPrincipalImg = document.getElementById('foto_principal_img');
        const fotoPrincipalIcon = document.getElementById('foto_principal_icon');
        const removeFotoPrincipalBtn = document.getElementById('remove_foto_principal');
        
        const fotosAdicionalesInput = document.getElementById('fotos_adicionales');
        const previewFotosAdicionales = document.getElementById('preview-fotos-adicionales');
        
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
        const fotoPrincipalDropzone = document.getElementById('foto_principal_dropzone');
        
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
        
        // Función para mostrar preview de fotos adicionales
        function showFotosAdicionalesPreview(files) {
            previewFotosAdicionales.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-20 h-20 rounded-lg object-cover border-2 border-gray-200" alt="Preview">
                            <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200" onclick="removeFotoAdicional(${index})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        `;
                        previewFotosAdicionales.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Event listener para fotos adicionales
        fotosAdicionalesInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length > 0) {
                showFotosAdicionalesPreview(files);
            }
        });
        
        // Función global para remover foto adicional
        window.removeFotoAdicional = function(index) {
            const dt = new DataTransfer();
            const files = Array.from(fotosAdicionalesInput.files);
            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            fotosAdicionalesInput.files = dt.files;
            
            // Actualizar preview
            showFotosAdicionalesPreview(fotosAdicionalesInput.files);
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
                showFotosAdicionalesPreview(files);
            }
        });
        
        // Validación del formulario
        const form = document.getElementById('conejoForm');
        form.addEventListener('submit', function(e) {
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
            
            // Verificar que se haya subido una foto principal
            if (!fotoPrincipalInput.files || fotoPrincipalInput.files.length === 0) {
                fotoPrincipalInput.classList.add('border-red-500');
                isValid = false;
                alert('Debes subir una foto principal.');
            } else {
                fotoPrincipalInput.classList.remove('border-red-500');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, completa todos los campos obligatorios y sube una foto principal.');
            }
        });
        
        // Debug: Mostrar información en consola
        console.log('Formulario de conejos cargado correctamente');
        console.log('Foto principal input:', fotoPrincipalInput);
        console.log('Fotos adicionales input:', fotosAdicionalesInput);
    });
</script>
@endsection