@extends('layouts.conejos')

@section('content')
<div class="space-y-6">
    <!-- Header con título y botón -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-3xl font-bold text-gray-900">Lista de Conejos</h1>
        <a href="{{ route('conejos.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nuevo Conejo
        </a>
    </div>
    
    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Tabla de conejos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($conejos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Información</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Detalles</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($conejos as $conejo)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Foto -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $conejo->foto_principal) }}" 
                                             class="h-20 w-20 rounded-lg object-cover border-2 border-gray-200 shadow-sm" 
                                             alt="Foto de {{ $conejo->nombre }}"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik00MCAyNEMzMS4xNjM0IDI0IDI0IDMxLjE2MzQgMjQgNDBDMjQgNDguODM2NiAzMS4xNjM0IDU2IDQwIDU2QzQ4LjgzNjYgNTYgNTYgNDguODM2NiA1NiA0MEM1NiAzMS4xNjM0IDQ4LjgzNjYgMjQgNDAgMjRaIiBmaWxsPSIjOUI5QkEwIi8+CjxwYXRoIGQ9Ik0yNCA2NEMyNCA1NS4xNjM0IDMxLjE2MzQgNDggNDAgNDhDNDguODM2NiA0OCA1NiA1NS4xNjM0IDU2IDY0QzU2IDcyLjgzNjYgNDguODM2NiA4MCA0MCA4MEMzMS4xNjM0IDgwIDI0IDcyLjgzNjYgMjQgNjRaIiBmaWxsPSIjOUI5QkEwIi8+Cjwvc3ZnPgo='">
                                    </div>
                                </td>
                                
                                <!-- Información básica -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="text-lg font-semibold text-gray-900">{{ $conejo->nombre }}</div>
                                        <div class="text-sm text-gray-600">Número: <span class="font-medium">{{ $conejo->numero }}</span></div>
                                        <div class="text-sm text-gray-600">Raza: <span class="font-medium">{{ $conejo->raza }}</span></div>
                                    </div>
                                </td>
                                
                                <!-- Detalles adicionales -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @if($conejo->color)
                                            <div class="text-sm text-gray-600">Color: <span class="font-medium">{{ $conejo->color }}</span></div>
                                        @endif
                                        @if($conejo->sexo)
                                            <div class="text-sm text-gray-600">Sexo: <span class="font-medium">{{ $conejo->sexo }}</span></div>
                                        @endif
                                        @if($conejo->fecha_nacimiento)
                                            <div class="text-sm text-gray-600">Nacimiento: <span class="font-medium">{{ $conejo->fecha_nacimiento->format('d/m/Y') }}</span></div>
                                        @endif
                                        <div class="text-lg font-bold text-indigo-600">{{ \App\Helpers\CLPHelper::format($conejo->precio) }}</div>
                                    </div>
                                </td>
                                
                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $conejo->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span class="w-2 h-2 mr-2 rounded-full {{ $conejo->disponible ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                        {{ $conejo->disponible ? 'Disponible' : 'No disponible' }}
                                    </span>
                                </td>
                                
                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <a href="{{ route('conejos.show', $conejo) }}" 
                                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-md hover:bg-indigo-100 hover:border-indigo-300 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </a>
                                        
                                        <a href="{{ route('conejos.edit', $conejo) }}" 
                                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-amber-700 bg-amber-50 border border-amber-200 rounded-md hover:bg-amber-100 hover:border-amber-300 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Editar
                                        </a>
                                        
                                        <form action="{{ route('conejos.destroy', $conejo) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 hover:border-red-300 transition-colors duration-200"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este conejo? Esta acción no se puede deshacer.')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay conejos</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza agregando tu primer conejo al criadero.</p>
                <div class="mt-6">
                    <a href="{{ route('conejos.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar Conejo
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection