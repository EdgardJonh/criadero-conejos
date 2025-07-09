@extends('layouts.conejos')

@section('content')
<div class="container">
    <h1>Panel de Administración</h1>
    <p class="mb-4">Bienvenido, {{ Auth::user()->name }}. Selecciona una opción del menú:</p>
    <div class="list-group mb-4">
        <a href="{{ route('conejos.index') }}" class="list-group-item list-group-item-action">Gestión de Conejos</a>
        <!-- Aquí puedes agregar más opciones de administración en el futuro -->
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
    </form>
</div>
@endsection 