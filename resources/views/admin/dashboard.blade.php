@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Panel de Administración</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.refugios.index') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Refugios Registrados</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalRefugios }}</p>
                </div>
                <div class="text-purple-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-blue-500 mt-4">Gestionar Refugios →</p>
        </a>
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