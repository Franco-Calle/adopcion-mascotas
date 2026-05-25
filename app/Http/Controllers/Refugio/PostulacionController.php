<?php

namespace App\Http\Controllers\Refugio;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    //
    public function index()
    {
        // Obtener postulaciones de las mascotas del refugio autenticado
        $postulaciones = Postulacion::whereHas('mascota', function($query) {
            $query->where('refugio_id', auth()->id());
        })
        ->with(['mascota', 'usuario'])
        ->latest()
        ->paginate(15);
        
        return view('refugio.postulaciones.index', compact('postulaciones'));
    }

    /**
     * Ver detalle de una postulación específica
     */
    public function show(Postulacion $postulacion)
    {
        // Verificar que la mascota de esta postulación pertenezca al refugio
        if ($postulacion->mascota->refugio_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta postulación');
        }
        
        return view('refugio.postulaciones.show', compact('postulacion'));
    }

    /**
     * Cambiar el estado de una postulación (aprobar/rechazar)
     */
    public function cambiarEstado(Request $request, Postulacion $postulacion)
    {
        // Verificar permisos
        if ($postulacion->mascota->refugio_id !== auth()->id()) {
            abort(403);
        }
        
        // Validar
        $request->validate([
            'estado' => 'required|in:pendiente,aprobado,rechazado',
            'comentario_admin' => 'nullable|string|max:500'
        ]);

        // Actualizar estado
        $postulacion->update([
            'estado' => $request->estado,
            'comentario_admin' => $request->comentario_admin
        ]);

        // Si se aprueba, cambiar estado de la mascota a "en_proceso"
        if ($request->estado === 'aprobado') {
            $postulacion->mascota->update(['estado' => 'en_proceso']);
        }
        
        // Si se rechaza y estaba en proceso, volver a disponible
        if ($request->estado === 'rechazado' && $postulacion->mascota->estado === 'en_proceso') {
            $postulacion->mascota->update(['estado' => 'disponible']);
        }

        return back()->with('success', 'Estado de la postulación actualizado correctamente');
    }
}
