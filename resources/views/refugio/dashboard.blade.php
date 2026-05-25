@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Panel del Refugio</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Mis Mascotas</h3>
            <p class="text-3xl font-bold">{{ $totalMascotas }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Disponibles</h3>
            <p class="text-3xl font-bold text-green-600">{{ $mascotasDisponibles }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Postulaciones</h3>
            <p class="text-3xl font-bold">{{ $totalPostulaciones }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Pendientes</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $postulacionesPendientes }}</p>
        </div>
    </div>
    
    <div class="flex gap-4">
        <a href="{{ route('refugio.mascotas.index') }}" 
           class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Gestionar Mascotas
        </a>
        <a href="{{ route('refugio.postulaciones.index') }}" 
           class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
            Ver Postulaciones
        </a>
    </div>
</div>
@endsection