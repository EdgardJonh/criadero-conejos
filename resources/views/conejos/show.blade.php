@extends('layouts.conejos')

@section('content')
<div class="container">
    <h1>Detalles del Conejo</h1>
    <div class="mb-3">
        <label class="form-label fw-bold">Foto Principal:</label><br>
        <img src="{{ asset('storage/' . $conejo->foto_principal) }}" width="200" alt="Foto principal">
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Fotos Adicionales:</label><br>
        @if($conejo->fotos_adicionales)
            @foreach($conejo->fotos_adicionales as $foto)
                <img src="{{ asset('storage/' . $foto) }}" width="100" class="me-2 mb-2" alt="Foto adicional">
            @endforeach
        @else
            <span>No hay fotos adicionales.</span>
        @endif
    </div>
    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Nombre:</strong> {{ $conejo->nombre }}</li>
        <li class="list-group-item"><strong>Número:</strong> {{ $conejo->numero }}</li>
        <li class="list-group-item"><strong>Raza:</strong> {{ $conejo->raza }}</li>
        <li class="list-group-item"><strong>Color:</strong> {{ $conejo->color }}</li>
        <li class="list-group-item"><strong>Sexo:</strong> {{ $conejo->sexo }}</li>
        <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> {{ $conejo->fecha_nacimiento }}</li>
        <li class="list-group-item"><strong>Descripción:</strong> {{ $conejo->descripcion }}</li>
        <li class="list-group-item"><strong>Precio:</strong> ${{ number_format($conejo->precio, 2) }}</li>
        <li class="list-group-item"><strong>Disponible:</strong> {{ $conejo->disponible ? 'Sí' : 'No' }}</li>
    </ul>
    <a href="{{ route('conejos.index') }}" class="btn btn-primary">Volver al listado</a>
    <a href="{{ route('conejos.edit', $conejo) }}" class="btn btn-warning">Editar</a>
</div>
@endsection 