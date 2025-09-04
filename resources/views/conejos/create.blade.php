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
                            <div class="flex flex-col text-sm text-gray-600 space-y-2">
                                <div class="flex space-x-4">
                                    <label for="foto_principal" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>📁 Subir foto</span>
                                        <input id="foto_principal" name="foto_principal" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                    <button type="button" id="camera_principal" class="bg-green-600 text-white px-3 py-1 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        📷 Tomar foto
                                    </button>
                                </div>
                                <p class="text-xs">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG hasta 50MB</p>
                            <p class="text-xs text-green-600 font-medium" id="camera_status_principal">📱 Cámara disponible en móviles</p>
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
                            <div class="flex flex-col text-sm text-gray-600 space-y-2">
                                <div class="flex space-x-4">
                                    <label for="fotos_adicionales" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>📁 Subir fotos</span>
                                        <input id="fotos_adicionales" name="fotos_adicionales[]" type="file" class="sr-only" accept="image/*" multiple>
                                    </label>
                                    <button type="button" id="camera_adicionales" class="bg-green-600 text-white px-3 py-1 rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        📷 Tomar fotos
                                    </button>
                                </div>
                                <p class="text-xs">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG hasta 50MB cada una</p>
                            <p class="text-xs text-green-600 font-medium" id="camera_status_adicionales">📱 Cámara disponible en móviles</p>
                        </div>
                    </div>
                    <!-- Preview de fotos adicionales -->
                    <div id="preview-fotos-adicionales" class="mt-3 grid grid-cols-4 gap-2"></div>
                    
                    <!-- Botón para limpiar todas las fotos adicionales -->
                    <div id="clear-adicionales-container" class="mt-2 hidden">
                        <button type="button" 
                                id="clear-fotos-adicionales" 
                                class="text-sm text-red-600 hover:text-red-800 underline">
                            🗑️ Limpiar todas las fotos
                        </button>
                    </div>
                    
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
                <button type="button" 
                        id="test-files-btn"
                        class="inline-flex justify-center py-3 px-6 border border-yellow-300 shadow-sm text-sm font-medium rounded-lg text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    🧪 Test Archivos
                </button>
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
            const clearContainer = document.getElementById('clear-adicionales-container');
            
            if (files.length === 0) {
                clearContainer.classList.add('hidden');
                return;
            }
            
            clearContainer.classList.remove('hidden');
            
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
            console.log('📸 Fotos adicionales seleccionadas:', files.length, 'archivos');
            console.log('📸 Input de fotos adicionales:', fotosAdicionalesInput);
            console.log('📸 Input name:', fotosAdicionalesInput.name);
            console.log('📸 Input multiple:', fotosAdicionalesInput.multiple);
            
            if (files.length > 0) {
                // Acumular archivos en lugar de reemplazar
                addFilesToInput(fotosAdicionalesInput, files);
                
                // Mostrar preview de todos los archivos acumulados
                showFotosAdicionalesPreview(fotosAdicionalesInput.files);
                
                // Log de cada archivo
                Array.from(fotosAdicionalesInput.files).forEach((file, index) => {
                    console.log(`Archivo ${index + 1}:`, file.name, 'Tamaño:', (file.size / 1024 / 1024).toFixed(2) + 'MB');
                });
            } else {
                console.log('⚠️ No se seleccionaron archivos en fotos adicionales');
            }
        });
        
        // Función global para remover foto adicional
        window.removeFotoAdicional = function(index) {
            console.log('🗑️ Removiendo foto adicional en índice:', index);
            const dt = new DataTransfer();
            const files = Array.from(fotosAdicionalesInput.files);
            console.log('📸 Fotos antes de remover:', files.length);
            
            // Remover el archivo en el índice especificado
            files.splice(index, 1);
            
            // Agregar los archivos restantes al DataTransfer
            files.forEach(file => dt.items.add(file));
            fotosAdicionalesInput.files = dt.files;
            
            console.log('📸 Fotos después de remover:', fotosAdicionalesInput.files.length);
            
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
            console.log('📸 Archivos arrastrados a fotos adicionales:', files.length);
            if (files.length > 0) {
                // Acumular archivos en lugar de reemplazar
                addFilesToInput(fotosAdicionalesInput, files);
                
                // Mostrar preview de todos los archivos acumulados
                showFotosAdicionalesPreview(fotosAdicionalesInput.files);
                console.log('📸 Fotos adicionales actualizadas después de drag & drop:', fotosAdicionalesInput.files.length);
            }
        });
        
        // Validación del formulario
        const form = document.getElementById('conejoForm');
        form.addEventListener('submit', function(e) {
            console.log('📤 Enviando formulario...');
            
            // Log de archivos que se van a enviar
            console.log('📸 Foto principal:', fotoPrincipalInput.files.length, 'archivos');
            if (fotoPrincipalInput.files.length > 0) {
                Array.from(fotoPrincipalInput.files).forEach((file, index) => {
                    console.log(`Foto principal ${index + 1}:`, file.name, 'Tamaño:', (file.size / 1024 / 1024).toFixed(2) + 'MB');
                });
            }
            
            console.log('📸 Fotos adicionales:', fotosAdicionalesInput.files.length, 'archivos');
            if (fotosAdicionalesInput.files.length > 0) {
                Array.from(fotosAdicionalesInput.files).forEach((file, index) => {
                    console.log(`Foto adicional ${index + 1}:`, file.name, 'Tamaño:', (file.size / 1024 / 1024).toFixed(2) + 'MB');
                });
            }
            
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
            } else {
                console.log('✅ Formulario válido, enviando...');
            }
        });
        
        // Funcionalidad de cámara
        const cameraPrincipalBtn = document.getElementById('camera_principal');
        const cameraAdicionalesBtn = document.getElementById('camera_adicionales');
        
        // Detectar si es un dispositivo móvil
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || 
                   ('ontouchstart' in window) || 
                   (navigator.maxTouchPoints > 0);
        }
        
        // Detectar si el dispositivo soporta cámara
        function isCameraSupported() {
            return 'mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices;
        }
        
        // Mostrar/ocultar botones de cámara según soporte
        function toggleCameraButtons() {
            const isMobile = isMobileDevice();
            const isSupported = isCameraSupported();
            
            // Mostrar botones en móviles siempre, en escritorio solo si hay soporte
            const shouldShow = isMobile || isSupported;
            
            cameraPrincipalBtn.style.display = shouldShow ? 'block' : 'none';
            cameraAdicionalesBtn.style.display = shouldShow ? 'block' : 'none';
            
            // Actualizar mensajes de estado
            const statusPrincipal = document.getElementById('camera_status_principal');
            const statusAdicionales = document.getElementById('camera_status_adicionales');
            
            if (isMobile) {
                statusPrincipal.textContent = '📱 Toca "Tomar foto" para usar la cámara';
                statusAdicionales.textContent = '📱 Toca "Tomar fotos" para usar la cámara';
                console.log('📱 Dispositivo móvil detectado - Botones de cámara habilitados');
            } else if (isSupported) {
                statusPrincipal.textContent = '📷 Cámara disponible';
                statusAdicionales.textContent = '📷 Cámara disponible';
                console.log('📷 Cámara soportada en escritorio - Botones habilitados');
            } else {
                statusPrincipal.textContent = '💻 Solo subida de archivos';
                statusAdicionales.textContent = '💻 Solo subida de archivos';
                console.log('💻 Escritorio sin cámara - Solo subida de archivos');
            }
        }
        
        // Función para abrir la cámara
        function openCamera(callback) {
            try {
                // Crear un input de archivo temporal con capture
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.capture = 'environment'; // Usar cámara trasera por defecto
                input.style.display = 'none';
                
                input.onchange = function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        console.log('📸 Foto capturada:', file.name, 'Tamaño:', (file.size / 1024 / 1024).toFixed(2) + 'MB');
                        callback(file);
                    }
                    // Limpiar el input después de usar
                    document.body.removeChild(input);
                };
                
                // Agregar al DOM temporalmente
                document.body.appendChild(input);
                
                // Simular click para abrir la cámara
                input.click();
                
            } catch (error) {
                console.error('Error al abrir la cámara:', error);
                alert('No se pudo abrir la cámara. Usa el botón "Subir foto" en su lugar.');
            }
        }
        
        // Función para convertir File a DataTransfer para fotos adicionales
        function addFileToInput(input, file) {
            console.log('📸 addFileToInput - Archivo recibido:', file.name);
            console.log('📸 addFileToInput - Archivos existentes antes:', input.files.length);
            
            const dt = new DataTransfer();
            const existingFiles = Array.from(input.files);
            existingFiles.push(file);
            existingFiles.forEach(f => dt.items.add(f));
            input.files = dt.files;
            
            console.log('📸 addFileToInput - Archivos después de agregar:', input.files.length);
            console.log('📸 addFileToInput - Archivos en DataTransfer:', Array.from(dt.files).map(f => f.name));
        }
        
        // Función para acumular múltiples archivos en fotos adicionales
        function addFilesToInput(input, newFiles) {
            console.log('📸 addFilesToInput - Archivos recibidos:', newFiles.length);
            console.log('📸 addFilesToInput - Archivos existentes antes:', input.files.length);
            
            const dt = new DataTransfer();
            const existingFiles = Array.from(input.files);
            
            // Agregar archivos existentes
            existingFiles.forEach(f => dt.items.add(f));
            
            // Agregar nuevos archivos
            Array.from(newFiles).forEach(file => {
                dt.items.add(file);
            });
            
            input.files = dt.files;
            
            console.log('📸 addFilesToInput - Archivos después de agregar:', input.files.length);
            console.log('📸 addFilesToInput - Archivos en DataTransfer:', Array.from(dt.files).map(f => f.name));
        }
        
        // Event listener para cámara de foto principal
        cameraPrincipalBtn.addEventListener('click', function() {
            openCamera(function(file) {
                // Asignar el archivo al input de foto principal
                const dt = new DataTransfer();
                dt.items.add(file);
                fotoPrincipalInput.files = dt.files;
                
                // Mostrar preview
                showFotoPrincipalPreview(file);
                
                console.log('Foto principal tomada:', file.name);
            });
        });
        
        // Event listener para cámara de fotos adicionales
        cameraAdicionalesBtn.addEventListener('click', function() {
            openCamera(function(file) {
                console.log('📸 Agregando foto adicional desde cámara:', file.name);
                
                // Agregar el archivo a las fotos adicionales
                addFileToInput(fotosAdicionalesInput, file);
                
                console.log('📸 Total de fotos adicionales después de agregar:', fotosAdicionalesInput.files.length);
                
                // Mostrar preview
                showFotosAdicionalesPreview(fotosAdicionalesInput.files);
                
                console.log('Foto adicional tomada:', file.name);
            });
        });
        
        // Inicializar botones de cámara
        toggleCameraButtons();
        
        // Botón de test para verificar archivos
        const testFilesBtn = document.getElementById('test-files-btn');
        testFilesBtn.addEventListener('click', function() {
            console.log('🧪 === TEST DE ARCHIVOS ===');
            console.log('📸 Foto principal:', fotoPrincipalInput.files.length, 'archivos');
            console.log('📸 Fotos adicionales:', fotosAdicionalesInput.files.length, 'archivos');
            
            // Verificar FormData
            const formData = new FormData(form);
            console.log('📤 FormData entries:');
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    console.log(`  ${key}:`, value.name, 'Tamaño:', (value.size / 1024 / 1024).toFixed(2) + 'MB');
                } else {
                    console.log(`  ${key}:`, value);
                }
            }
            
            // Verificar inputs específicos
            console.log('📸 Input foto_principal files:', Array.from(fotoPrincipalInput.files).map(f => f.name));
            console.log('📸 Input fotos_adicionales files:', Array.from(fotosAdicionalesInput.files).map(f => f.name));
            
            console.log('🧪 === FIN TEST ===');
        });
        
        // Botón para limpiar todas las fotos adicionales
        const clearFotosAdicionalesBtn = document.getElementById('clear-fotos-adicionales');
        clearFotosAdicionalesBtn.addEventListener('click', function() {
            console.log('🗑️ Limpiando todas las fotos adicionales');
            
            // Limpiar el input
            fotosAdicionalesInput.value = '';
            
            // Limpiar el preview
            showFotosAdicionalesPreview([]);
            
            console.log('✅ Fotos adicionales limpiadas');
        });
        
        // Debug: Mostrar información en consola
        console.log('Formulario de conejos cargado correctamente');
        console.log('Foto principal input:', fotoPrincipalInput);
        console.log('Fotos adicionales input:', fotosAdicionalesInput);
        console.log('Botones de cámara configurados');
        console.log('User Agent:', navigator.userAgent);
        console.log('Es móvil:', isMobileDevice());
        console.log('Soporte cámara:', isCameraSupported());
        console.log('Touch points:', navigator.maxTouchPoints);
    });
</script>
@endsection