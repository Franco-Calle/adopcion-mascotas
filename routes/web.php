<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Refugio\RefugioDashboardController;
use App\Http\Controllers\Refugio\MascotaController as RefugioMascotaController;
use App\Http\Controllers\Refugio\PostulacionController as RefugioPostulacionController;
use App\Http\Controllers\Usuario\GaleriaController;
use App\Http\Controllers\Usuario\PostulacionController as UsuarioPostulacionController;
use Illuminate\Support\Facades\Route;

// Ruta API para obtener datos de mascota (usada por el modal)
Route::get('/api/mascota/{mascota}', function (App\Models\Mascota $mascota) {
    return response()->json([
        'id' => $mascota->id,
        'nombre' => $mascota->nombre,
        'tipo' => $mascota->tipo,
        'raza' => $mascota->raza,
        'edad' => $mascota->edad,
        'tamaño' => $mascota->tamaño,
        'historia' => $mascota->historia,
        'estado' => $mascota->estado,
        'esterilizado' => $mascota->esterilizado,
        'vacunado' => $mascota->vacunado,
        'fotos' => $mascota->fotos->map(function ($foto) {
            return ['url' => $foto->url];
        }),
        'refugio' => [
            'name' => $mascota->refugio->name,
            'telefono' => $mascota->refugio->telefono,
        ]
    ]);
})->name('api.mascota.show');

// Rutas PÚBLICAS (sin autenticación)
Route::get('/', [GaleriaController::class, 'index'])->name('galeria.index');
Route::get('/mascota/{mascota}', [GaleriaController::class, 'show'])->name('galeria.show');

// Rutas PROTEGIDAS (requieren autenticación)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'refugio' => redirect()->route('refugio.dashboard'),
            'usuario' => redirect()->route('usuario.postulaciones.mis'),
            default => redirect('/'),
        };
    })->name('dashboard');

    // Admin routes
    // Grupo ADMIN
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ========== GESTIÓN DE REFUGIOS ==========
        Route::resource('refugios', App\Http\Controllers\Admin\RefugioController::class)
            ->except(['create', 'store', 'edit', 'update', 'destroy', 'show']);

        // Rutas personalizadas para refugios
        Route::get('/refugios', [App\Http\Controllers\Admin\RefugioController::class, 'index'])->name('refugios.index');
        Route::get('/refugios/create', [App\Http\Controllers\Admin\RefugioController::class, 'create'])->name('refugios.create');
        Route::post('/refugios', [App\Http\Controllers\Admin\RefugioController::class, 'store'])->name('refugios.store');
        Route::get('/refugios/{refugio}', [App\Http\Controllers\Admin\RefugioController::class, 'show'])->name('refugios.show');
        Route::get('/refugios/{refugio}/edit', [App\Http\Controllers\Admin\RefugioController::class, 'edit'])->name('refugios.edit');
        Route::put('/refugios/{refugio}', [App\Http\Controllers\Admin\RefugioController::class, 'update'])->name('refugios.update');
        Route::delete('/refugios/{refugio}', [App\Http\Controllers\Admin\RefugioController::class, 'destroy'])->name('refugios.destroy');

        // Refugios eliminados
        Route::get('/refugios-trashed', [App\Http\Controllers\Admin\RefugioController::class, 'trashed'])->name('refugios.trashed');
        Route::post('/refugios/{id}/restore', [App\Http\Controllers\Admin\RefugioController::class, 'restore'])->name('refugios.restore');
    });

    // Refugio routes
    Route::middleware(['role:refugio'])->prefix('refugio')->name('refugio.')->group(function () {
        Route::get('/dashboard', [RefugioDashboardController::class, 'index'])->name('dashboard');
        Route::resource('mascotas', RefugioMascotaController::class);
        Route::delete('foto/{foto}', [RefugioMascotaController::class, 'eliminarFoto'])->name('foto.eliminar');
        Route::get('postulaciones', [RefugioPostulacionController::class, 'index'])->name('postulaciones.index');
        Route::get('postulaciones/{postulacion}', [RefugioPostulacionController::class, 'show'])->name('postulaciones.show');
        Route::patch('postulaciones/{postulacion}/estado', [RefugioPostulacionController::class, 'cambiarEstado'])->name('postulaciones.estado');
    });

    // Usuario routes
    Route::middleware(['role:usuario'])->prefix('usuario')->name('usuario.')->group(function () {
        Route::get('postulaciones', [UsuarioPostulacionController::class, 'misPostulaciones'])->name('postulaciones.mis');
        Route::get('mascota/{mascota}/postular', [UsuarioPostulacionController::class, 'create'])->name('postular.create');
        Route::post('mascota/{mascota}/postular', [UsuarioPostulacionController::class, 'store'])->name('postular.store');
        Route::get('/mascota/{mascota}', [GaleriaController::class, 'show'])->name('galeria.show');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
