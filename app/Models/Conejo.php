<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'precio' => 'integer',
    ];

    /**
     * Relación con el modelo ManejoSanitario
     */
    public function manejoSanitario(): HasMany
    {
        return $this->hasMany(ManejoSanitario::class);
    }
}
