<?php

namespace App\Http\Controllers\Refugio;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use App\Models\User;
use App\Models\Postulacion;
use App\Models\FotoMascota;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    //
    use UploadTrait;

    public function index()
    {
        $mascotas = auth()->user()->mascotas()->with('fotos')->latest()->paginate(10);
        return view('refugio.mascotas.index', compact('mascotas'));
    }

    public function create()
    {
        return view('refugio.mascotas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'historia' => 'required|string',
            'fotos' => 'required|array|min:1|max:10',
            'fotos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Crear la mascota
        $mascota = Mascota::create([
            'refugio_id' => auth()->id(),
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'raza' => $request->raza,
            'edad' => $request->edad,
            'tamaño' => $request->tamaño,
            'historia' => $request->historia,
            'esterilizado' => $request->has('esterilizado'),
            'vacunado' => $request->has('vacunado'),
        ]);

        // Subir y guardar múltiples fotos
        $orden = 0;
        foreach ($request->file('fotos') as $index => $foto) {
            $url = $this->uploadToCloudinary($foto, 'mascotas/' . $mascota->id);
            
            FotoMascota::create([
                'mascota_id' => $mascota->id,
                'url' => $url,
                'orden' => $orden++,
                'es_principal' => $index === 0, // La primera foto es la principal
            ]);
        }

        return redirect()->route('refugio.mascotas.index')
            ->with('success', 'Mascota publicada exitosamente con ' . $orden . ' fotos');
    }

    public function edit(Mascota $mascota)
    {
        // Verificar que la mascota pertenezca al refugio logueado
        if ($mascota->refugio_id !== auth()->id()) {
            abort(403);
        }
        
        return view('refugio.mascotas.edit', compact('mascota'));
    }

    public function update(Request $request, Mascota $mascota)
    {
        // Actualizar datos básicos
        $mascota->update($request->only([
            'nombre', 'tipo', 'raza', 'edad', 'tamaño', 
            'historia', 'estado', 'esterilizado', 'vacunado'
        ]));

        // Si suben nuevas fotos, agregarlas
        if ($request->hasFile('nuevas_fotos')) {
            $ordenActual = $mascota->fotos->count();
            foreach ($request->file('nuevas_fotos') as $foto) {
                $url = $this->uploadToCloudinary($foto, 'mascotas/' . $mascota->id);
                FotoMascota::create([
                    'mascota_id' => $mascota->id,
                    'url' => $url,
                    'orden' => $ordenActual++,
                ]);
            }
        }

        return redirect()->route('refugio.mascotas.index')
            ->with('success', 'Mascota actualizada correctamente');
    }

    public function show(Mascota $mascota)
{
    // Verificar que la mascota pertenezca al refugio logueado
    if ($mascota->refugio_id !== auth()->id()) {
        abort(403, 'No tienes permiso para ver esta mascota');
    }
    
    // Cargar las relaciones necesarias
    $mascota->load(['fotos', 'postulaciones' => function($query) {
        $query->latest();
    }]);
    
    return view('refugio.mascotas.show', compact('mascota'));
}

    public function destroy(Mascota $mascota)
    {
        $mascota->delete(); // Las fotos se eliminan en cascada
        return redirect()->route('refugio.mascotas.index')
            ->with('success', 'Mascota eliminada');
    }

    // Eliminar una foto específica
    public function eliminarFoto(FotoMascota $foto)
    {
        if ($foto->mascota->refugio_id !== auth()->id()) {
            abort(403);
        }
        
        $foto->delete();
        return back()->with('success', 'Foto eliminada');
    }
}
