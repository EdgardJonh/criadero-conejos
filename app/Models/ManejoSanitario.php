<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManejoSanitario extends Model
{
    protected $table = 'manejo_sanitario';

    protected $fillable = [
        'conejo_id',
        'fecha_control',
        'tipo_control',
        'producto_aplicado',
        'dosis',
        'via_administracion',
        'veterinario',
        'observaciones',
        'proximo_control',
        'estado',
    ];

    protected $casts = [
        'fecha_control' => 'date',
        'proximo_control' => 'date',
    ];

    /**
     * Relación con el modelo Conejo
     */
    public function conejo(): BelongsTo
    {
        return $this->belongsTo(Conejo::class);
    }
}
