<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mascota;
use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RefugioController extends Controller
{
    /**
     * Mostrar listado de refugios
     */
    public function index()
    {
        $refugios = User::where('role', 'refugio')
            ->withCount(['mascotas', 'postulaciones'])
            ->latest()
            ->paginate(15);
        
        return view('admin.refugios.index', compact('refugios'));
    }

    /**
     * Mostrar formulario para crear nuevo refugio
     */
    public function create()
    {
        return view('admin.refugios.create');
    }

    /**
     * Guardar nuevo refugio en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'descripcion' => 'nullable|string|max:1000',
            'logo_url' => 'nullable|url|max:255',
        ]);

        $refugio = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'refugio',
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'descripcion' => $request->descripcion,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.refugios.index')
            ->with('success', 'Refugio "'.$refugio->name.'" registrado exitosamente');
    }

    /**
     * Mostrar detalles de un refugio específico
     */
    public function show(User $refugio)
    {
        // Verificar que sea un refugio
        if ($refugio->role !== 'refugio') {
            abort(404, 'El usuario no es un refugio');
        }

        // Cargar relaciones y estadísticas
        $refugio->load(['mascotas' => function($query) {
            $query->withCount('postulaciones');
        }]);

        $totalMascotas = $refugio->mascotas()->count();
        $mascotasDisponibles = $refugio->mascotas()->where('estado', 'disponible')->count();
        $mascotasAdoptadas = $refugio->mascotas()->where('estado', 'adoptado')->count();
        $totalPostulaciones = Postulacion::whereHas('mascota', function($q) use ($refugio) {
            $q->where('refugio_id', $refugio->id);
        })->count();
        
        $postulacionesPendientes = Postulacion::whereHas('mascota', function($q) use ($refugio) {
            $q->where('refugio_id', $refugio->id);
        })->where('estado', 'pendiente')->count();

        return view('admin.refugios.show', compact(
            'refugio', 
            'totalMascotas', 
            'mascotasDisponibles',
            'mascotasAdoptadas',
            'totalPostulaciones',
            'postulacionesPendientes'
        ));
    }

    /**
     * Mostrar formulario para editar refugio
     */
    public function edit(User $refugio)
    {
        if ($refugio->role !== 'refugio') {
            abort(404);
        }
        
        return view('admin.refugios.edit', compact('refugio'));
    }

    /**
     * Actualizar información del refugio
     */
    public function update(Request $request, User $refugio)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($refugio->id),
            ],
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'descripcion' => 'nullable|string|max:1000',
            'logo_url' => 'nullable|url|max:255',
        ]);

        // Si se proporciona nueva contraseña
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $refugio->password = Hash::make($request->password);
        }

        $refugio->update([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'descripcion' => $request->descripcion,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.refugios.show', $refugio)
            ->with('success', 'Refugio actualizado correctamente');
    }

    /**
     * Eliminar un refugio (soft delete)
     */
    public function destroy(User $refugio)
    {
        // Verificar que sea un refugio
        if ($refugio->role !== 'refugio') {
            abort(404);
        }

        $nombre = $refugio->name;
        $refugio->delete(); // Soft delete

        return redirect()->route('admin.refugios.index')
            ->with('success', 'Refugio "'.$nombre.'" eliminado correctamente');
    }

    /**
     * Restaurar un refugio eliminado
     */
    public function restore($id)
    {
        $refugio = User::withTrashed()->findOrFail($id);
        
        if ($refugio->role !== 'refugio') {
            abort(404);
        }
        
        $refugio->restore();
        
        return redirect()->route('admin.refugios.index')
            ->with('success', 'Refugio restaurado correctamente');
    }

    /**
     * Ver listado de refugios eliminados
     */
    public function trashed()
    {
        $refugios = User::onlyTrashed()
            ->where('role', 'refugio')
            ->latest()
            ->paginate(15);
        
        return view('admin.refugios.trashed', compact('refugios'));
    }
}