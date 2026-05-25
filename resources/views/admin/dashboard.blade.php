@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Panel de Administración</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Total Refugios</h3>
            <p class="text-3xl font-bold">{{ $totalRefugios }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Total Usuarios</h3>
            <p class="text-3xl font-bold">{{ $totalUsuarios }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Total Mascotas</h3>
            <p class="text-3xl font-bold">{{ $totalMascotas }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Adopciones Exitosas</h3>
            <p class="text-3xl font-bold">{{ $adopcionesExitosas }}</p>
        </div>
    </div>
</div>
@endsection