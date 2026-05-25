<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Refugio\RefugioDashboardController;
use App\Http\Controllers\Refugio\MascotaController as RefugioMascotaController;
use App\Http\Controllers\Refugio\PostulacionController as RefugioPostulacionController;
use App\Http\Controllers\Usuario\GaleriaController;
use App\Http\Controllers\Usuario\PostulacionController as UsuarioPostulacionController;
use Illuminate\Support\Facades\Route;

// Rutas PÚBLICAS (sin autenticación)
Route::get('/', [GaleriaController::class, 'index'])->name('galeria.index');
Route::get('/mascota/{mascota}', [GaleriaController::class, 'show'])->name('galeria.show');

// Rutas PROTEGIDAS (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'refugio' => redirect()->route('refugio.dashboard'),
            'usuario' => redirect()->route('usuario.postulaciones.mis'),
            default => redirect('/'),
        };
    })->name('dashboard');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
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
    });
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';