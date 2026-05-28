@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🏠 {{ $refugio->name }}</h1>
            <p class="text-gray-600 mt-1">Detalles del refugio y estadísticas</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.refugios.edit', $refugio) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                ✏️ Editar Refugio
            </a>
            <a href="{{ route('admin.refugios.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                ← Volver
            </a>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Mascotas</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalMascotas }}</p>
                </div>
                <div class="text-blue-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Mascotas Disponibles</p>
                    <p class="text-3xl font-bold text-green-600">{{ $mascotasDisponibles }}</p>
                </div>
                <div class="text-green-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Adopciones</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalPostulaciones }}</p>
                </div>
                <div class="text-purple-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Postulaciones Pendientes</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $postulacionesPendientes }}</p>
                </div>
                <div class="text-yellow-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Refugio -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg">📋 Información del Refugio</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-gray-500 text-sm">Nombre</label>
                        <p class="font-medium text-gray-800">{{ $refugio->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm">Email</label>
                        <p class="font-medium text-gray-800">{{ $refugio->email }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm">Teléfono</label>
                        <p class="font-medium text-gray-800">{{ $refugio->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm">Dirección</label>
                        <p class="font-medium text-gray-800">{{ $refugio->direccion ?? 'No registrada' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm">Descripción</label>
                        <p class="text-gray-700">{{ $refugio->descripcion ?? 'Sin descripción' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm">Registrado el</label>
                        <p class="font-medium text-gray-800">{{ $refugio->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg">🖼️ Últimas Mascotas</h2>
                </div>
                <div class="p-4">
                    @forelse($refugio->mascotas->take(5) as $mascota)
                    <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                        @if($mascota->fotos->isNotEmpty())
                            <img src="{{ $mascota->fotos->first()->url }}" 
                                 alt="{{ $mascota->nombre }}"
                                 class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                📸
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $mascota->nombre }}</p>
                            <p class="text-xs text-gray-500">{{ $mascota->tipo }} • {{ $mascota->edad }}</p>
                        </div>
                        <div>
                            @if($mascota->estado === 'disponible')
                                <span class="text-xs text-green-600">✓</span>
                            @elseif($mascota->estado === 'adoptado')
                                <span class="text-xs text-gray-500">❤️</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No hay mascotas registradas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection