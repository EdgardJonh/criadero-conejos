@extends('layouts.conejos')

@section('content')
<div class="space-y-6">
    <!-- Header con título -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detalles del Control Sanitario</h1>
        <div class="flex space-x-3">
            <a href="{{ route('manejo-sanitario.edit', $manejoSanitario) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar
            </a>
            <a href="{{ route('manejo-sanitario.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a la lista
            </a>
        </div>
    </div>
    
    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
        <!-- Información del Conejo -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Información del Conejo</h2>
            <div class="flex items-center">
                <div class="flex-shrink-0 h-16 w-16">
                    <img src="{{ asset('storage/' . $manejoSanitario->conejo->foto_principal) }}" 
                         class="h-16 w-16 rounded-full object-cover border-2 border-gray-200" 
                         alt="Foto de {{ $manejoSanitario->conejo->nombre }}"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0zMiAyMEMyNi40NzcgMjAgMjIgMjQuNDc3IDIyIDMwQzIyIDM1LjUyMyAyNi40NzcgNDAgMzIgNDBDMzcuNTIzIDQwIDQyIDM1LjUyMyA0MiAzMEM0MiAyNC40NzcgMzcuNTIzIDIwIDMyIDIwWiIgZmlsbD0iIzlCOUJBQCIvPgo8cGF0aCBkPSJNMjIgNTJDMjIgNDYuNDc3IDI2LjQ3NyA0MiAzMiA0MkMzNy41MjMgNDIgNDIgNDYuNDc3IDQyIDUyQzQyIDU3LjUyMyAzNy41MjMgNjIgMzIgNjJDMjYuNDc3IDYyIDIyIDU3LjUyMyAyMiA1MloiIGZpbGw9IiM5QjlCQTAiLz4KPC9zdmc+Cg=='">
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-900">{{ $manejoSanitario->conejo->nombre }}</h3>
                    <p class="text-sm text-gray-600">Número: {{ $manejoSanitario->conejo->numero }}</p>
                    <p class="text-sm text-gray-600">Raza: {{ $manejoSanitario->conejo->raza }}</p>
                    @if($manejoSanitario->conejo->sexo)
                        <p class="text-sm text-gray-600">Sexo: {{ $manejoSanitario->conejo->sexo }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Detalles del Control Sanitario -->
        <div class="px-6 py-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Detalles del Control Sanitario</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Fecha del Control -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Fecha del Control</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $manejoSanitario->fecha_control->format('d/m/Y') }}</dd>
                </div>
                
                <!-- Tipo de Control -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Tipo de Control</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $manejoSanitario->tipo_control }}
                        </span>
                    </dd>
                </div>
                
                <!-- Estado -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                    <dd class="mt-1">
                        @php
                            $estadoColors = [
                                'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                'Completado' => 'bg-green-100 text-green-800',
                                'En tratamiento' => 'bg-blue-100 text-blue-800',
                                'Recuperado' => 'bg-emerald-100 text-emerald-800'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $estadoColors[$manejoSanitario->estado] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $manejoSanitario->estado }}
                        </span>
                    </dd>
                </div>
                
                <!-- Veterinario -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Veterinario</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $manejoSanitario->veterinario ?? 'No especificado' }}</dd>
                </div>
                
                <!-- Producto Aplicado -->
                @if($manejoSanitario->producto_aplicado)
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Producto Aplicado</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $manejoSanitario->producto_aplicado }}</dd>
                </div>
                @endif
                
                <!-- Dosis -->
                @if($manejoSanitario->dosis)
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Dosis</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $manejoSanitario->dosis }}</dd>
                </div>
                @endif
                
                <!-- Vía de Administración -->
                @if($manejoSanitario->via_administracion)
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Vía de Administración</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $manejoSanitario->via_administracion }}</dd>
                </div>
                @endif
                
                <!-- Próximo Control -->
                @if($manejoSanitario->proximo_control)
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Próximo Control</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $manejoSanitario->proximo_control->format('d/m/Y') }}</dd>
                </div>
                @endif
            </div>
            
            <!-- Observaciones -->
            @if($manejoSanitario->observaciones)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Observaciones</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-line">{{ $manejoSanitario->observaciones }}</p>
                </div>
            </div>
            @endif
            
            <!-- Información de Registro -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                    <div>
                        <span class="font-medium">Registrado el:</span> {{ $manejoSanitario->created_at->format('d/m/Y H:i') }}
                    </div>
                    @if($manejoSanitario->updated_at != $manejoSanitario->created_at)
                    <div>
                        <span class="font-medium">Última actualización:</span> {{ $manejoSanitario->updated_at->format('d/m/Y H:i') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Acciones -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <form action="{{ route('manejo-sanitario.destroy', $manejoSanitario) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 hover:border-red-300 transition-colors duration-200"
                            onclick="return confirm('¿Estás seguro de que quieres eliminar este control sanitario?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar Control
                    </button>
                </form>
                
                <div class="flex space-x-3">
                    <a href="{{ route('conejos.show', $manejoSanitario->conejo) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-md hover:bg-indigo-100 hover:border-indigo-300 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Ver Conejo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
