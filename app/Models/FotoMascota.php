<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoMascota extends Model
{
    protected $fillable = [
        'mascota_id',
        'url',
        'orden',
        'es_principal',
    ];

    /**
     * Relación: Una foto pertenece a una mascota
     */
    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }
}
