<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mascota;
use App\Models\Postulacion;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        $totalRefugios = User::where('role', 'refugio')->count();
        $totalUsuarios = User::where('role', 'usuario')->count();
        $totalMascotas = Mascota::count();
        $totalPostulaciones = Postulacion::count();
        $adopcionesExitosas = Postulacion::where('estado', 'aprobado')->count();
        
        return view('admin.dashboard', compact(
            'totalRefugios', 
            'totalUsuarios', 
            'totalMascotas',
            'totalPostulaciones',
            'adopcionesExitosas'
        ));
    }
}
