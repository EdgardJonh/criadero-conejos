@extends('layouts.conejos')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Detalles del Conejo</h1>
        <div class="space-x-2">
            <a href="{{ route('conejos.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">Volver al listado</a>
            <a href="{{ route('conejos.edit', $conejo) }}" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors duration-200">Editar</a>
        </div>
    </div>
    
    <div class="bg-white shadow overflow-hidden rounded-lg mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4">Fotos</h2>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-500 mb-2">Foto Principal:</p>
                    <img src="{{ asset('storage/' . $conejo->foto_principal) }}" class="h-64 w-full object-cover rounded-lg" alt="Foto principal">
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-2">Fotos Adicionales:</p>
                    <div class="grid grid-cols-3 gap-2">
                        @if($conejo->fotos_adicionales)
                            @foreach($conejo->fotos_adicionales as $foto)
                                <img src="{{ asset('storage/' . $foto) }}" class="h-24 w-full object-cover rounded-lg" alt="Foto adicional">
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500 col-span-3">No hay fotos adicionales.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4">Información</h2>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conejo->nombre }}</dd>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Número</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conejo->numero }}</dd>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Raza</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conejo->raza }}</dd>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Color</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conejo->color ?: 'No especificado' }}</dd>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Sexo</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conejo->sexo ?: 'No especificado' }}</dd>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conejo->fecha_nacimiento ? $conejo->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}</dd>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conejo->descripcion ?: 'Sin descripción' }}</dd>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Precio</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ \App\Helpers\CLPHelper::format($conejo->precio) }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $conejo->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $conejo->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection