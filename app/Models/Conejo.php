<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conejo extends Model
{
    protected $fillable = [
        'nombre',
        'foto_principal',
        'fotos_adicionales',
        'numero',
        'raza',
        'color',
        'sexo',
        'fecha_nacimiento',
        'descripcion',
        'precio',
        'disponible',
    ];

    protected $casts = [
        'fotos_adicionales' => 'array',
        'fecha_nacimiento' => 'date',
        'disponible' => 'boolean',
        'precio' => 'decimal:2',
    ];
}
