@extends('layouts.conejos')

@section('content')
<div class="space-y-6">
    <!-- Header con título -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Editar Control Sanitario</h1>
        <a href="{{ route('manejo-sanitario.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
    
    <div class="bg-white shadow-lg rounded-xl border border-gray-200 p-8">
        <form action="{{ route('manejo-sanitario.update', $manejoSanitario) }}" method="POST" id="manejoSanitarioForm">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Conejo -->
                <div class="col-span-1">
                    <label for="conejo_id" class="block text-sm font-medium text-gray-700 mb-2">Conejo *</label>
                    <select name="conejo_id" 
                            id="conejo_id" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('conejo_id') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione un conejo</option>
                        @foreach($conejos as $conejo)
                            <option value="{{ $conejo->id }}" {{ old('conejo_id', $manejoSanitario->conejo_id) == $conejo->id ? 'selected' : '' }}>
                                {{ $conejo->nombre }} ({{ $conejo->numero }})
                            </option>
                        @endforeach
                    </select>
                    @error('conejo_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Fecha Control -->
                <div class="col-span-1">
                    <label for="fecha_control" class="block text-sm font-medium text-gray-700 mb-2">Fecha del Control *</label>
                    <input type="date" 
                           name="fecha_control" 
                           id="fecha_control" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('fecha_control') border-red-500 @enderror" 
                           value="{{ old('fecha_control', $manejoSanitario->fecha_control->format('Y-m-d')) }}" 
                           required>
                    @error('fecha_control')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Tipo Control -->
                <div class="col-span-1">
                    <label for="tipo_control" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Control *</label>
                    <select name="tipo_control" 
                            id="tipo_control" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('tipo_control') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione el tipo de control</option>
                        <option value="Vacunación" {{ old('tipo_control', $manejoSanitario->tipo_control) == 'Vacunación' ? 'selected' : '' }}>Vacunación</option>
                        <option value="Desparasitación" {{ old('tipo_control', $manejoSanitario->tipo_control) == 'Desparasitación' ? 'selected' : '' }}>Desparasitación</option>
                        <option value="Revisión médica" {{ old('tipo_control', $manejoSanitario->tipo_control) == 'Revisión médica' ? 'selected' : '' }}>Revisión médica</option>
                        <option value="Tratamiento" {{ old('tipo_control', $manejoSanitario->tipo_control) == 'Tratamiento' ? 'selected' : '' }}>Tratamiento</option>
                        <option value="Enfermedad" {{ old('tipo_control', $manejoSanitario->tipo_control) == 'Enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                        <option value="Otro" {{ old('tipo_control', $manejoSanitario->tipo_control) == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('tipo_control')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Estado -->
                <div class="col-span-1">
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                    <select name="estado" 
                            id="estado" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('estado') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione el estado</option>
                        <option value="Pendiente" {{ old('estado', $manejoSanitario->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Completado" {{ old('estado', $manejoSanitario->estado) == 'Completado' ? 'selected' : '' }}>Completado</option>
                        <option value="En tratamiento" {{ old('estado', $manejoSanitario->estado) == 'En tratamiento' ? 'selected' : '' }}>En tratamiento</option>
                        <option value="Recuperado" {{ old('estado', $manejoSanitario->estado) == 'Recuperado' ? 'selected' : '' }}>Recuperado</option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Producto Aplicado -->
                <div class="col-span-1">
                    <label for="producto_aplicado" class="block text-sm font-medium text-gray-700 mb-2">Producto Aplicado</label>
                    <input type="text" 
                           name="producto_aplicado" 
                           id="producto_aplicado" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('producto_aplicado') border-red-500 @enderror" 
                           value="{{ old('producto_aplicado', $manejoSanitario->producto_aplicado) }}" 
                           placeholder="Ej: Vacuna Mixomatosis, Ivermectina">
                    @error('producto_aplicado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Dosis -->
                <div class="col-span-1">
                    <label for="dosis" class="block text-sm font-medium text-gray-700 mb-2">Dosis</label>
                    <input type="text" 
                           name="dosis" 
                           id="dosis" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('dosis') border-red-500 @enderror" 
                           value="{{ old('dosis', $manejoSanitario->dosis) }}" 
                           placeholder="Ej: 0.5ml, 1 comprimido">
                    @error('dosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Vía de Administración -->
                <div class="col-span-1">
                    <label for="via_administracion" class="block text-sm font-medium text-gray-700 mb-2">Vía de Administración</label>
                    <select name="via_administracion" 
                            id="via_administracion" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('via_administracion') border-red-500 @enderror">
                        <option value="">Seleccione la vía</option>
                        <option value="Oral" {{ old('via_administracion', $manejoSanitario->via_administracion) == 'Oral' ? 'selected' : '' }}>Oral</option>
                        <option value="Inyectable" {{ old('via_administracion', $manejoSanitario->via_administracion) == 'Inyectable' ? 'selected' : '' }}>Inyectable</option>
                        <option value="Tópica" {{ old('via_administracion', $manejoSanitario->via_administracion) == 'Tópica' ? 'selected' : '' }}>Tópica</option>
                    </select>
                    @error('via_administracion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Veterinario -->
                <div class="col-span-1">
                    <label for="veterinario" class="block text-sm font-medium text-gray-700 mb-2">Veterinario</label>
                    <input type="text" 
                           name="veterinario" 
                           id="veterinario" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('veterinario') border-red-500 @enderror" 
                           value="{{ old('veterinario', $manejoSanitario->veterinario) }}" 
                           placeholder="Nombre del veterinario">
                    @error('veterinario')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Próximo Control -->
                <div class="col-span-1">
                    <label for="proximo_control" class="block text-sm font-medium text-gray-700 mb-2">Próximo Control</label>
                    <input type="date" 
                           name="proximo_control" 
                           id="proximo_control" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('proximo_control') border-red-500 @enderror" 
                           value="{{ old('proximo_control', $manejoSanitario->proximo_control ? $manejoSanitario->proximo_control->format('Y-m-d') : '') }}">
                    @error('proximo_control')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Observaciones -->
            <div class="mt-6">
                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                <textarea name="observaciones" 
                          id="observaciones" 
                          rows="4" 
                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('observaciones') border-red-500 @enderror" 
                          placeholder="Notas adicionales sobre el estado de salud del conejo, reacciones, recomendaciones, etc.">{{ old('observaciones', $manejoSanitario->observaciones) }}</textarea>
                @error('observaciones')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Botones -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('manejo-sanitario.index') }}" 
                   class="inline-flex justify-center py-3 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Actualizar Control Sanitario
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        const form = document.getElementById('manejoSanitarioForm');
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
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, completa todos los campos obligatorios.');
            }
        });
        
        console.log('Formulario de edición de manejo sanitario cargado correctamente');
    });
</script>
@endsection
@endsection
