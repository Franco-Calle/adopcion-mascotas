<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Postulacion extends Model
{
    protected $fillable = [
        'mascota_id',
        'usuario_id',
        'nombre_completo',
        'email',
        'telefono',
        'direccion',
        'razones',
        'experiencia_mascotas',
        'estado',
        'comentario_admin',
    ];

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
