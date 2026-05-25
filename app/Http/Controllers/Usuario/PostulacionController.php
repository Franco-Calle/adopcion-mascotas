<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use App\Models\Postulacion;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    //
    public function create(Mascota $mascota)
    {
        // Verificar que la mascota esté disponible
        if ($mascota->estado !== 'disponible') {
            return redirect()->route('galeria.index')
                ->with('error', 'Esta mascota ya no está disponible');
        }
        
        return view('usuario.postulaciones.create', compact('mascota'));
    }

    public function store(Request $request, Mascota $mascota)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:500',
            'razones' => 'required|string|min:50',
            'experiencia_mascotas' => 'nullable|string',
        ]);

        // Verificar que no haya postulado antes a esta mascota
        $existe = Postulacion::where('mascota_id', $mascota->id)
            ->where('usuario_id', auth()->id())
            ->exists();

        if ($existe) {
            return back()->with('error', 'Ya has postulado a esta mascota anteriormente');
        }

        Postulacion::create([
            'mascota_id' => $mascota->id,
            'usuario_id' => auth()->id(),
            'nombre_completo' => $request->nombre_completo,
            'email' => auth()->user()->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'razones' => $request->razones,
            'experiencia_mascotas' => $request->experiencia_mascotas,
        ]);

        return redirect()->route('usuario.postulaciones.mis')
            ->with('success', '¡Postulación enviada! El refugio evaluará tu solicitud.');
    }

    public function misPostulaciones()
    {
        $postulaciones = auth()->user()->postulaciones()
            ->with('mascota')
            ->latest()
            ->paginate(10);
            
        return view('usuario.postulaciones.mis', compact('postulaciones'));
    }
}
