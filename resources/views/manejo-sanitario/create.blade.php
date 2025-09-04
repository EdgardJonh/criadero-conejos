@extends('layouts.conejos')

@section('content')
<div class="space-y-6">
    <!-- Header con título -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Nuevo Control Sanitario</h1>
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
    
    <!-- Panel de Asistente de Voz -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Asistente de Voz</h3>
                    <p class="text-sm text-gray-600">Dicta la información para llenar automáticamente los campos</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button" 
                        id="startVoiceInput" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                    <span id="voiceButtonText">Iniciar Dictado</span>
                </button>
                <button type="button" 
                        id="clearVoiceData" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Limpiar
                </button>
            </div>
        </div>
        
        <!-- Estado del reconocimiento -->
        <div id="voiceStatus" class="mt-4 hidden">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-700">
                        <span id="voiceStatusText">Escuchando...</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Transcripción en tiempo real -->
        <div id="voiceTranscript" class="mt-4 hidden">
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Transcripción:</h4>
                <p id="transcriptText" class="text-sm text-gray-700 italic"></p>
            </div>
        </div>
        
        <!-- Instrucciones de uso -->
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="text-sm font-medium text-blue-900 mb-2">Comandos de Voz Disponibles:</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h5 class="text-xs font-semibold text-blue-900 mb-1">Campos de Selección:</h5>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• <strong>Conejo:</strong> "Conejo Luna" o "Seleccionar conejo número 5"</li>
                        <li>• <strong>Tipo:</strong> "Tipo vacunación" o "Control desparasitación"</li>
                        <li>• <strong>Estado:</strong> "Estado completado" o "Marcar como pendiente"</li>
                        <li>• <strong>Vía:</strong> "Vía oral", "Vía inyectable" o "Vía tópica"</li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xs font-semibold text-blue-900 mb-1">Campos de Texto:</h5>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• <strong>Producto:</strong> "Producto Ivermectina"</li>
                        <li>• <strong>Dosis:</strong> "Dosis 0.5 mililitros"</li>
                        <li>• <strong>Veterinario:</strong> "Veterinario Dr. García"</li>
                        <li>• <strong>Observaciones:</strong> "Observaciones El conejo presenta..."</li>
                        <li>• <strong>Próximo control:</strong> "Próximo control 15 de enero"</li>
                    </ul>
                </div>
            </div>
            
            <!-- Comando de IA -->
            <div class="mt-4 bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-lg p-3">
                <h5 class="text-xs font-semibold text-purple-900 mb-1">🤖 Comando de IA Inteligente:</h5>
                <p class="text-xs text-purple-800 mb-2">Di: <strong>"Asistente, llena todo"</strong> seguido de una descripción completa</p>
                <p class="text-xs text-purple-700 italic">Ejemplo: "Asistente, llena todo. Conejo Luna, vacunación completada, producto Ivermectina, dosis 0.5ml, vía oral, veterinario Dr. García, observaciones buen estado, próximo control en 30 días"</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200 p-8">
        <form action="{{ route('manejo-sanitario.store') }}" method="POST" id="manejoSanitarioForm">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Conejo -->
                <div class="col-span-1">
                    <label for="conejo_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Conejo *
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <select name="conejo_id" 
                            id="conejo_id" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('conejo_id') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione un conejo</option>
                        @foreach($conejos as $conejo)
                            <option value="{{ $conejo->id }}" {{ old('conejo_id') == $conejo->id ? 'selected' : '' }}>
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
                           value="{{ old('fecha_control', date('Y-m-d')) }}" 
                           required>
                    @error('fecha_control')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Tipo Control -->
                <div class="col-span-1">
                    <label for="tipo_control" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Control *
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <select name="tipo_control" 
                            id="tipo_control" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('tipo_control') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione el tipo de control</option>
                        <option value="Vacunación" {{ old('tipo_control') == 'Vacunación' ? 'selected' : '' }}>Vacunación</option>
                        <option value="Desparasitación" {{ old('tipo_control') == 'Desparasitación' ? 'selected' : '' }}>Desparasitación</option>
                        <option value="Revisión médica" {{ old('tipo_control') == 'Revisión médica' ? 'selected' : '' }}>Revisión médica</option>
                        <option value="Tratamiento" {{ old('tipo_control') == 'Tratamiento' ? 'selected' : '' }}>Tratamiento</option>
                        <option value="Enfermedad" {{ old('tipo_control') == 'Enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                        <option value="Otro" {{ old('tipo_control') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('tipo_control')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Estado -->
                <div class="col-span-1">
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado *
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <select name="estado" 
                            id="estado" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('estado') border-red-500 @enderror" 
                            required>
                        <option value="">Seleccione el estado</option>
                        <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Completado" {{ old('estado', 'Completado') == 'Completado' ? 'selected' : '' }}>Completado</option>
                        <option value="En tratamiento" {{ old('estado') == 'En tratamiento' ? 'selected' : '' }}>En tratamiento</option>
                        <option value="Recuperado" {{ old('estado') == 'Recuperado' ? 'selected' : '' }}>Recuperado</option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Producto Aplicado -->
                <div class="col-span-1">
                    <label for="producto_aplicado" class="block text-sm font-medium text-gray-700 mb-2">
                        Producto Aplicado
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <input type="text" 
                           name="producto_aplicado" 
                           id="producto_aplicado" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('producto_aplicado') border-red-500 @enderror" 
                           value="{{ old('producto_aplicado') }}" 
                           placeholder="Ej: Vacuna Mixomatosis, Ivermectina">
                    @error('producto_aplicado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Dosis -->
                <div class="col-span-1">
                    <label for="dosis" class="block text-sm font-medium text-gray-700 mb-2">
                        Dosis
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <input type="text" 
                           name="dosis" 
                           id="dosis" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('dosis') border-red-500 @enderror" 
                           value="{{ old('dosis') }}" 
                           placeholder="Ej: 0.5ml, 1 comprimido">
                    @error('dosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Vía de Administración -->
                <div class="col-span-1">
                    <label for="via_administracion" class="block text-sm font-medium text-gray-700 mb-2">
                        Vía de Administración
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <select name="via_administracion" 
                            id="via_administracion" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('via_administracion') border-red-500 @enderror">
                        <option value="">Seleccione la vía</option>
                        <option value="Oral" {{ old('via_administracion') == 'Oral' ? 'selected' : '' }}>Oral</option>
                        <option value="Inyectable" {{ old('via_administracion') == 'Inyectable' ? 'selected' : '' }}>Inyectable</option>
                        <option value="Tópica" {{ old('via_administracion') == 'Tópica' ? 'selected' : '' }}>Tópica</option>
                    </select>
                    @error('via_administracion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Veterinario -->
                <div class="col-span-1">
                    <label for="veterinario" class="block text-sm font-medium text-gray-700 mb-2">
                        Veterinario
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <input type="text" 
                           name="veterinario" 
                           id="veterinario" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('veterinario') border-red-500 @enderror" 
                           value="{{ old('veterinario') }}" 
                           placeholder="Nombre del veterinario">
                    @error('veterinario')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Próximo Control -->
                <div class="col-span-1">
                    <label for="proximo_control" class="block text-sm font-medium text-gray-700 mb-2">
                        Próximo Control
                        <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                    </label>
                    <input type="date" 
                           name="proximo_control" 
                           id="proximo_control" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('proximo_control') border-red-500 @enderror" 
                           value="{{ old('proximo_control') }}">
                    @error('proximo_control')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Observaciones -->
            <div class="mt-6">
                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                    Observaciones
                    <span class="text-xs text-indigo-600 ml-1">🎤 Dictable</span>
                </label>
                <textarea name="observaciones" 
                          id="observaciones" 
                          rows="4" 
                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('observaciones') border-red-500 @enderror" 
                          placeholder="Notas adicionales sobre el estado de salud del conejo, reacciones, recomendaciones, etc.">{{ old('observaciones') }}</textarea>
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
                    Guardar Control Sanitario
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales para el reconocimiento de voz
        let recognition = null;
        let isListening = false;
        let currentTranscript = '';
        
        // Verificar soporte del navegador
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();
            
            // Configuración del reconocimiento
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = 'es-ES';
            
            // Elementos del DOM
            const startButton = document.getElementById('startVoiceInput');
            const clearButton = document.getElementById('clearVoiceData');
            const voiceStatus = document.getElementById('voiceStatus');
            const voiceStatusText = document.getElementById('voiceStatusText');
            const voiceTranscript = document.getElementById('voiceTranscript');
            const transcriptText = document.getElementById('transcriptText');
            const voiceButtonText = document.getElementById('voiceButtonText');
            
            // Eventos del reconocimiento
            recognition.onstart = function() {
                isListening = true;
                startButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                startButton.classList.add('bg-red-600', 'hover:bg-red-700');
                voiceButtonText.textContent = 'Detener Dictado';
                voiceStatus.classList.remove('hidden');
                voiceTranscript.classList.remove('hidden');
                voiceStatusText.textContent = 'Escuchando...';
                console.log('Reconocimiento de voz iniciado');
            };
            
            recognition.onresult = function(event) {
                let interimTranscript = '';
                let finalTranscript = '';
                
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const transcript = event.results[i][0].transcript;
                    if (event.results[i].isFinal) {
                        finalTranscript += transcript;
                    } else {
                        interimTranscript += transcript;
                    }
                }
                
                currentTranscript = finalTranscript + interimTranscript;
                transcriptText.textContent = currentTranscript;
                
                // Procesar el texto final
                if (finalTranscript) {
                    processVoiceInput(finalTranscript);
                }
            };
            
            recognition.onerror = function(event) {
                console.error('Error en reconocimiento de voz:', event.error);
                voiceStatusText.textContent = `Error: ${event.error}`;
                stopListening();
            };
            
            recognition.onend = function() {
                stopListening();
            };
            
            // Función para detener el reconocimiento
            function stopListening() {
                isListening = false;
                startButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                startButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                voiceButtonText.textContent = 'Iniciar Dictado';
                voiceStatusText.textContent = 'Reconocimiento detenido';
                setTimeout(() => {
                    voiceStatus.classList.add('hidden');
                    voiceTranscript.classList.add('hidden');
                }, 2000);
            }
            
            // Función para procesar el input de voz
            function processVoiceInput(text) {
                const lowerText = text.toLowerCase();
                console.log('Procesando texto:', text);
                
                // Verificar si es comando de IA
                if (lowerText.includes('asistente') && lowerText.includes('llena todo')) {
                    processAICommand(text);
                    return;
                }
                
                // Patrones de reconocimiento expandidos
                const patterns = {
                    conejo: /(?:conejo|seleccionar conejo|conejo número|conejo numero)\s+(.+?)(?:\s|$)/i,
                    tipo: /(?:tipo|control)\s+(vacunación|desparasitación|revisión médica|revision medica|tratamiento|enfermedad|otro)/i,
                    estado: /(?:estado|marcar como)\s+(pendiente|completado|en tratamiento|recuperado)/i,
                    producto: /(?:producto|medicamento|vacuna|desparasitante)\s+(.+?)(?:\s|$)/i,
                    dosis: /(?:dosis|cantidad)\s+(.+?)(?:\s|$)/i,
                    via: /(?:vía|via|administración)\s+(oral|inyectable|tópica|topica)/i,
                    veterinario: /(?:veterinario|vet|doctor|dr\.?)\s+(.+?)(?:\s|$)/i,
                    observaciones: /(?:observaciones|notas|comentarios)\s+(.+)/i,
                    proximo: /(?:próximo|proximo|siguiente)\s+(?:control|cita)\s+(.+)/i
                };
                
                // Procesar cada patrón
                Object.keys(patterns).forEach(field => {
                    const match = text.match(patterns[field]);
                    if (match) {
                        fillField(field, match[1].trim());
                    }
                });
                
                // Procesamiento adicional para fechas
                processDateInput(text);
            }
            
            // Función para procesar comandos de IA
            function processAICommand(text) {
                console.log('Procesando comando de IA:', text);
                
                // Extraer información del comando de IA
                const aiPatterns = {
                    conejo: /(?:conejo|conejo número|conejo numero)\s+([^,]+?)(?:,|\s+vacunación|\s+desparasitación|\s+revisión|\s+tratamiento|\s+enfermedad|\s+otro)/i,
                    tipo: /(vacunación|desparasitación|revisión médica|revision medica|tratamiento|enfermedad|otro)(?:\s+completada?|\s+pendiente|\s+en tratamiento|\s+recuperado)/i,
                    estado: /(completada?|pendiente|en tratamiento|recuperado)(?:\s+producto|\s+dosis|\s+vía|\s+veterinario|\s+observaciones|\s+próximo)/i,
                    producto: /(?:producto|medicamento|vacuna|desparasitante)\s+([^,]+?)(?:\s+dosis|\s+vía|\s+veterinario|\s+observaciones|\s+próximo)/i,
                    dosis: /(?:dosis|cantidad)\s+([^,]+?)(?:\s+vía|\s+veterinario|\s+observaciones|\s+próximo)/i,
                    via: /(?:vía|via|administración)\s+(oral|inyectable|tópica|topica)(?:\s+veterinario|\s+observaciones|\s+próximo)/i,
                    veterinario: /(?:veterinario|vet|doctor|dr\.?)\s+([^,]+?)(?:\s+observaciones|\s+próximo)/i,
                    observaciones: /(?:observaciones|notas|comentarios)\s+([^,]+?)(?:\s+próximo|\s+siguiente)/i,
                    proximo: /(?:próximo|proximo|siguiente)\s+(?:control|cita)\s+(?:en\s+)?([^,]+?)(?:\s+días|\s+meses|\s+semanas|$)/i
                };
                
                // Procesar cada patrón de IA
                Object.keys(aiPatterns).forEach(field => {
                    const match = text.match(aiPatterns[field]);
                    if (match) {
                        fillField(field, match[1].trim());
                    }
                });
                
                // Procesamiento adicional para fechas en comandos de IA
                processDateInput(text);
                
                // Mostrar confirmación
                showAIConfirmation();
            }
            
            // Función para mostrar confirmación de IA
            function showAIConfirmation() {
                const statusText = document.getElementById('voiceStatusText');
                statusText.textContent = '🤖 IA: Campos llenados automáticamente';
                statusText.classList.add('text-purple-600', 'font-semibold');
                
                setTimeout(() => {
                    statusText.classList.remove('text-purple-600', 'font-semibold');
                    statusText.textContent = 'Escuchando...';
                }, 3000);
            }
            
            // Función para llenar campos específicos
            function fillField(field, value) {
                const fieldMap = {
                    conejo: 'conejo_id',
                    tipo: 'tipo_control',
                    estado: 'estado',
                    producto: 'producto_aplicado',
                    dosis: 'dosis',
                    via: 'via_administracion',
                    veterinario: 'veterinario',
                    observaciones: 'observaciones',
                    proximo: 'proximo_control'
                };
                
                const fieldName = fieldMap[field];
                if (fieldName) {
                    const element = document.getElementById(fieldName);
                    if (element) {
                        if (element.tagName === 'SELECT') {
                            // Para selects, buscar la opción que contenga el valor
                            const options = element.querySelectorAll('option');
                            let found = false;
                            
                            for (let option of options) {
                                const optionText = option.textContent.toLowerCase();
                                const optionValue = option.value.toLowerCase();
                                const searchValue = value.toLowerCase();
                                
                                // Búsqueda más inteligente para conejos
                                if (field === 'conejo') {
                                    if (optionText.includes(searchValue) || 
                                        optionValue.includes(searchValue) ||
                                        searchValue.includes(optionText.split(' ')[0])) {
                                        element.value = option.value;
                                        found = true;
                                        break;
                                    }
                                } else {
                                    // Búsqueda normal para otros selects
                                    if (optionValue.includes(searchValue) || 
                                        optionText.includes(searchValue) ||
                                        searchValue.includes(optionValue)) {
                                        element.value = option.value;
                                        found = true;
                                        break;
                                    }
                                }
                            }
                            
                            if (!found && field === 'conejo') {
                                console.log(`Conejo "${value}" no encontrado. Conejos disponibles:`, 
                                    Array.from(options).map(opt => opt.textContent));
                            }
                        } else {
                            element.value = value;
                        }
                        
                        // Efecto visual
                        element.classList.add('bg-green-50', 'border-green-300');
                        setTimeout(() => {
                            element.classList.remove('bg-green-50', 'border-green-300');
                        }, 2000);
                        
                        console.log(`Campo ${fieldName} llenado con: ${value}`);
                    }
                }
            }
            
            // Función para procesar fechas
            function processDateInput(text) {
                const datePatterns = [
                    /(?:próximo|proximo|siguiente)\s+(?:control|cita)\s+(\d{1,2})\s+(?:de\s+)?(enero|febrero|marzo|abril|mayo|junio|julio|agosto|septiembre|octubre|noviembre|diciembre)/i,
                    /(?:próximo|proximo|siguiente)\s+(?:control|cita)\s+en\s+(\d+)\s+días/i
                ];
                
                datePatterns.forEach(pattern => {
                    const match = text.match(pattern);
                    if (match) {
                        let dateValue = '';
                        if (match[2] && match[2] !== 'días') {
                            // Fecha específica
                            const months = {
                                'enero': '01', 'febrero': '02', 'marzo': '03', 'abril': '04',
                                'mayo': '05', 'junio': '06', 'julio': '07', 'agosto': '08',
                                'septiembre': '09', 'octubre': '10', 'noviembre': '11', 'diciembre': '12'
                            };
                            const day = match[1].padStart(2, '0');
                            const month = months[match[2].toLowerCase()];
                            const year = new Date().getFullYear();
                            dateValue = `${year}-${month}-${day}`;
                        } else if (match[1] && match[2] === 'días') {
                            // Fecha relativa
                            const days = parseInt(match[1]);
                            const futureDate = new Date();
                            futureDate.setDate(futureDate.getDate() + days);
                            dateValue = futureDate.toISOString().split('T')[0];
                        }
                        
                        if (dateValue) {
                            const proximoControlField = document.getElementById('proximo_control');
                            if (proximoControlField) {
                                proximoControlField.value = dateValue;
                                proximoControlField.classList.add('bg-green-50', 'border-green-300');
                                setTimeout(() => {
                                    proximoControlField.classList.remove('bg-green-50', 'border-green-300');
                                }, 2000);
                                console.log(`Fecha próximo control establecida: ${dateValue}`);
                            }
                        }
                    }
                });
            }
            
            // Event listeners
            startButton.addEventListener('click', function() {
                if (isListening) {
                    recognition.stop();
                } else {
                    try {
                        recognition.start();
                    } catch (error) {
                        console.error('Error al iniciar reconocimiento:', error);
                        alert('Error al iniciar el reconocimiento de voz. Asegúrate de permitir el acceso al micrófono.');
                    }
                }
            });
            
            clearButton.addEventListener('click', function() {
                // Limpiar campos llenados por voz (excepto campos obligatorios)
                const voiceFields = ['conejo_id', 'tipo_control', 'estado', 'producto_aplicado', 'dosis', 'via_administracion', 'veterinario', 'observaciones', 'proximo_control'];
                voiceFields.forEach(fieldName => {
                    const element = document.getElementById(fieldName);
                    if (element) {
                        element.value = '';
                    }
                });
                
                // Limpiar transcripción
                transcriptText.textContent = '';
                currentTranscript = '';
                
                console.log('Campos limpiados');
            });
            
        } else {
            // Navegador no compatible
            const startButton = document.getElementById('startVoiceInput');
            startButton.disabled = true;
            startButton.textContent = 'No compatible';
            startButton.classList.add('opacity-50', 'cursor-not-allowed');
            
            console.warn('Reconocimiento de voz no soportado en este navegador');
        }
        
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
        
        console.log('Formulario de manejo sanitario con asistente de voz cargado correctamente');
    });
</script>
@endsection
@endsection
