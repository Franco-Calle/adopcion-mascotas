<?php

namespace App\Http\Controllers\Refugio;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use App\Models\Postulacion;
use Illuminate\Http\Request;

class RefugioDashboardController extends Controller
{
    //
    public function index()
    {
        // Aquí luego pasaremos solo sus mascotas
        $totalMascotas = auth()->user()->mascotas()->count();
        $mascotasDisponibles = auth()->user()->mascotas()->where('estado', 'disponible')->count();
        $totalPostulaciones = Postulacion::whereHas('mascota', function($q) {
            $q->where('refugio_id', auth()->id());
        })->count();
        
        $postulacionesPendientes = Postulacion::whereHas('mascota', function($q) {
            $q->where('refugio_id', auth()->id());
        })->where('estado', 'pendiente')->count();
        
        return view('refugio.dashboard', compact(
            'totalMascotas',
            'mascotasDisponibles',
            'totalPostulaciones',
            'postulacionesPendientes'
        ));
    }
}
