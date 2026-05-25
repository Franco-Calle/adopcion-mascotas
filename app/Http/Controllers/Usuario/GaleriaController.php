<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;

class GaleriaController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Mascota::where('estado', 'disponible')
            ->with(['refugio', 'fotos']);

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('tamaño')) {
            $query->where('tamaño', $request->tamaño);
        }

        $mascotas = $query->latest()->paginate(12);
        $tipos = Mascota::select('tipo')->distinct()->pluck('tipo');
        
        return view('usuario.galeria.index', compact('mascotas', 'tipos'));
    }

    public function show(Mascota $mascota)
    {
        $mascota->load(['refugio', 'fotos', 'postulaciones' => function($q) {
            $q->where('usuario_id', auth()->id());
        }]);
        
        return view('usuario.galeria.show', compact('mascota'));
    }
}
