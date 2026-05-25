<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Mascota extends Model
{
    protected $fillable = [
        'refugio_id',
        'nombre',
        'tipo',
        'raza',
        'edad',
        'tamaño',
        'historia',
        'estado',
        'esterilizado',
        'vacunado',
    ];
    public function refugio(): BelongsTo
    {
        return $this->belongsTo(User::class, 'refugio_id');
    }   

    public function fotos(): HasMany
    {
        return $this->hasMany(FotoMascota::class)->orderBy('orden');
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class);
    }
}
