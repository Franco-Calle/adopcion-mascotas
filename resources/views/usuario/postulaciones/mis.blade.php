@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📋 Mis Postulaciones</h1>
            <a href="{{ route('galeria.index') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Ver más mascotas
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($postulaciones->count() > 0)
            <div class="space-y-6">
                @foreach($postulaciones as $postulacion)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="flex flex-col md:flex-row">
                        <!-- Foto de la mascota -->
                        <div class="md:w-48 h-48 bg-gray-200">
                            @if($postulacion->mascota->fotos->isNotEmpty())
                                <img src="{{ $postulacion->mascota->fotos->first()->url }}" 
                                     alt="{{ $postulacion->mascota->nombre }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-gray-400">📸</span>
                                </div>
                            @endif
                        </div>

                        <!-- Información -->
                        <div class="flex-1 p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">
                                        {{ $postulacion->mascota->nombre }}
                                    </h2>
                                    <p class="text-gray-600">
                                        {{ $postulacion->mascota->tipo }} • {{ $postulacion->mascota->edad }} • {{ $postulacion->mascota->tamaño }}
                                    </p>
                                </div>
                                
                                <!-- Estado de la postulación -->
                                <div>
                                    @switch($postulacion->estado)
                                        @case('pendiente')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                                                ⏳ En revisión
                                            </span>
                                            @break
                                        @case('aprobado')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                                ✅ Pre-aprobado
                                            </span>
                                            @break
                                        @case('rechazado')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                                ❌ No seleccionado
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                            </div>

                            <!-- Estado de la mascota -->
                            <div class="mt-2">
                                <span class="text-sm text-gray-500">
                                    Estado de la mascota: 
                                    <strong>
                                        {{ $postulacion->mascota->estado == 'disponible' ? 'Disponible' : 
                                           ($postulacion->mascota->estado == 'en_proceso' ? 'En proceso de adopción' : 'Adoptado') }}
                                    </strong>
                                </span>
                            </div>

                            <!-- Fecha de postulación -->
                            <p class="text-sm text-gray-500 mt-2">
                                Postulaste el: {{ $postulacion->created_at->format('d/m/Y H:i') }}
                            </p>

                            <!-- Comentario del admin/refugio -->
                            @if($postulacion->comentario_admin)
                            <div class="mt-4 bg-blue-50 rounded-lg p-3">
                                <p class="text-sm font-semibold text-blue-800 mb-1">📌 Mensaje del refugio:</p>
                                <p class="text-sm text-blue-700">{{ $postulacion->comentario_admin }}</p>
                            </div>
                            @endif

                            <!-- Botones de acción -->
                            <div class="mt-4 flex gap-3">
                                <a href="{{ route('galeria.show', $postulacion->mascota) }}" 
                                   class="text-blue-500 hover:text-blue-700 text-sm">
                                    Ver detalles de la mascota →
                                </a>
                                
                                @if($postulacion->estado == 'aprobado' && $postulacion->mascota->estado == 'en_proceso')
                                    <span class="text-green-600 text-sm">
                                        🎉 ¡El refugio se pondrá en contacto contigo pronto!
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $postulaciones->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🐾</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Aún no has postulado</h3>
                <p class="text-gray-600 mb-6">Explora nuestra galería y encuentra a tu nuevo mejor amigo</p>
                <a href="{{ route('galeria.index') }}" 
                   class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                    Ver mascotas disponibles
                </a>
            </div>
        @endif
    </div>
</div>
@endsection