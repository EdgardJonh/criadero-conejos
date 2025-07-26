@extends('layouts.conejos')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Lista de Conejos</h1>
        <a href="{{ route('conejos.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
            Nuevo Conejo
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto Principal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disponible</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($conejos as $conejo)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $conejo->foto_principal) }}" class="h-16 w-16 rounded-md object-cover" alt="Foto principal">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $conejo->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $conejo->numero }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $conejo->raza }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($conejo->precio, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $conejo->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $conejo->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 flex">
                            <a href="{{ route('conejos.show', $conejo) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 px-3 py-1 rounded-md hover:bg-indigo-200 transition-colors duration-200">Ver</a>
                            <a href="{{ route('conejos.edit', $conejo) }}" class="text-amber-600 hover:text-amber-900 bg-amber-100 px-3 py-1 rounded-md hover:bg-amber-200 transition-colors duration-200">Editar</a>
                            <form action="{{ route('conejos.destroy', $conejo) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-md hover:bg-red-200 transition-colors duration-200" onclick="return confirm('¿Seguro que deseas eliminar este conejo?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection