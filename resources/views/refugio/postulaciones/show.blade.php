@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Botón volver -->
    <div class="mb-4">
        <a href="{{ route('refugio.postulaciones.index') }}" class="text-blue-500 hover:text-blue-700 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a postulaciones
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información de la Mascota -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información del Postulante
                    </h2>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Datos personales -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Datos Personales
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 rounded-lg p-4">
                            <div>
                                <p class="text-sm text-gray-500">Nombre completo</p>
                                <p class="font-medium">{{ $postulacion->nombre_completo }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $postulacion->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Teléfono</p>
                                <p class="font-medium">{{ $postulacion->telefono }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Fecha de postulación</p>
                                <p class="font-medium">{{ $postulacion->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Dirección
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $postulacion->direccion }}</p>
                        </div>
                    </div>

                    <!-- Motivos de adopción -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            ¿Por qué quiere adoptar?
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 leading-relaxed">{{ $postulacion->razones }}</p>
                        </div>
                    </div>

                    <!-- Experiencia previa -->
                    @if($postulacion->experiencia_mascotas)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Experiencia previa con mascotas
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 leading-relaxed">{{ $postulacion->experiencia_mascotas }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Lateral - Acciones y Estado -->
        <div class="lg:col-span-1">
            <!-- Estado actual -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Estado de la Postulación
                    </h2>
                </div>
                <div class="p-6 text-center">
                    @switch($postulacion->estado)
                        @case('pendiente')
                            <div class="text-yellow-600 mb-2">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-2xl font-bold">Pendiente</p>
                                <p class="text-gray-600 text-sm mt-2">Esperando tu evaluación</p>
                            </div>
                            @break
                        @case('aprobado')
                            <div class="text-green-600 mb-2">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-2xl font-bold">Aprobado</p>
                                <p class="text-gray-600 text-sm mt-2">Postulación aceptada</p>
                            </div>
                            @break
                        @case('rechazado')
                            <div class="text-red-600 mb-2">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-2xl font-bold">Rechazado</p>
                                <p class="text-gray-600 text-sm mt-2">Postulación no aceptada</p>
                            </div>
                            @break
                    @endswitch
                </div>
            </div>

            <!-- Formulario de cambio de estado -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-4">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Cambiar Estado
                    </h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('refugio.postulaciones.estado', $postulacion) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Seleccionar estado</label>
                            <select name="estado" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="pendiente" {{ $postulacion->estado == 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                                <option value="aprobado" {{ $postulacion->estado == 'aprobado' ? 'selected' : '' }}>✅ Aprobar</option>
                                <option value="rechazado" {{ $postulacion->estado == 'rechazado' ? 'selected' : '' }}>❌ Rechazar</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Comentario (opcional)</label>
                            <textarea name="comentario_admin" 
                                      rows="4"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                      placeholder="Agrega un comentario para el postulante...">{{ old('comentario_admin', $postulacion->comentario_admin) }}</textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 rounded-lg transition">
                            Actualizar Estado
                        </button>
                    </form>

                    <!-- Información de la mascota -->
                    <div class="mt-6 pt-6 border-t">
                        <h3 class="font-semibold text-gray-700 mb-2">Mascota relacionada</h3>
                        <div class="flex items-center gap-3">
                            @if($postulacion->mascota->fotos->isNotEmpty())
                                <img src="{{ $postulacion->mascota->fotos->first()->url }}" 
                                     alt="{{ $postulacion->mascota->nombre }}"
                                     class="w-12 h-12 rounded-full object-cover">
                            @endif
                            <div>
                                <p class="font-medium">{{ $postulacion->mascota->nombre }}</p>
                                <p class="text-sm text-gray-500">{{ $postulacion->mascota->tipo }} • {{ $postulacion->mascota->edad }}</p>
                            </div>
                        </div>
                        <a href="{{ route('refugio.mascotas.edit', $postulacion->mascota) }}" 
                           class="text-blue-500 hover:text-blue-700 text-sm mt-2 inline-block">
                            Ver ficha de la mascota →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection