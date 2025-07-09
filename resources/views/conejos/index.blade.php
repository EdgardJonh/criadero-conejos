@extends('layouts.conejos')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Conejos</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('conejos.create') }}" class="btn btn-primary mb-3">Nuevo Conejo</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Foto Principal</th>
                <th>Nombre</th>
                <th>Número</th>
                <th>Raza</th>
                <th>Precio</th>
                <th>Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conejos as $conejo)
                <tr>
                    <td><img src="{{ asset('storage/' . $conejo->foto_principal) }}" width="80" alt="Foto principal"></td>
                    <td>{{ $conejo->nombre }}</td>
                    <td>{{ $conejo->numero }}</td>
                    <td>{{ $conejo->raza }}</td>
                    <td>${{ number_format($conejo->precio, 2) }}</td>
                    <td>{{ $conejo->disponible ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('conejos.show', $conejo) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('conejos.edit', $conejo) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('conejos.destroy', $conejo) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este conejo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 