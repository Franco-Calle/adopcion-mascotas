@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Botón volver -->
    <div class="mb-4">
        <a href="{{ route('refugio.mascotas.index') }}" class="text-blue-500 hover:text-blue-700 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a mis mascotas
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Galería de Fotos -->
            <div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100">
                @if($mascota->fotos->isNotEmpty())
                    <!-- Foto Principal con carrusel -->
                    <div class="relative mb-4">
                        <img src="{{ $mascota->fotos->first()->url }}" 
                             alt="{{ $mascota->nombre }}"
                             class="w-full h-96 object-cover rounded-lg shadow-lg"
                             id="mainImage">
                        
                        <!-- Controles del carrusel si hay múltiples fotos -->
                        @if($mascota->fotos->count() > 1)
                            <button onclick="previousImage()" 
                                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button onclick="nextImage()" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                    
                    <!-- Miniaturas -->
                    @if($mascota->fotos->count() > 1)
                    <div id="thumbnail-container" class="grid grid-cols-5 gap-2">
                        @foreach($mascota->fotos as $index => $foto)
                        <div class="cursor-pointer rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-blue-500' : 'border-transparent' }} hover:border-blue-300 transition"
                             onclick="setMainImage('{{ $foto->url }}', {{ $index }})">
                            <img src="{{ $foto->url }}" 
                                 alt="Miniatura {{ $index + 1 }}"
                                 class="w-full h-20 object-cover">
                        </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-500">No hay fotos disponibles</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Información de la Mascota -->
            <div class="p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">{{ $mascota->nombre }}</h1>
                            <div class="flex gap-2 mt-2">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    {{ $mascota->tipo }}
                                </span>
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    {{ $mascota->tamaño }}
                                </span>
                                @if($mascota->raza)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    {{ $mascota->raza }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            @switch($mascota->estado)
                                @case('disponible')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                        ✓ Disponible
                                    </span>
                                    @break
                                @case('en_proceso')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                                        ⏳ En proceso de adopción
                                    </span>
                                    @break
                                @case('adoptado')
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                                        ❤️ Adoptado
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>

                <!-- Información Básica -->
                <div class="space-y-4 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Información General
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Edad</p>
                                <p class="font-medium">{{ $mascota->edad }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tamaño</p>
                                <p class="font-medium">{{ $mascota->tamaño }}</p>
                            </div>
                            @if($mascota->raza)
                            <div>
                                <p class="text-sm text-gray-500">Raza</p>
                                <p class="font-medium">{{ $mascota->raza }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-500">Registrado</p>
                                <p class="font-medium">{{ $mascota->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de Salud -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Salud y Cuidados
                        </h3>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">{{ $mascota->esterilizado ? '✅' : '❌' }}</span>
                                <span>{{ $mascota->esterilizado ? 'Esterilizado' : 'No esterilizado' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">{{ $mascota->vacunado ? '✅' : '❌' }}</span>
                                <span>{{ $mascota->vacunado ? 'Vacunado' : 'Vacunación pendiente' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Historia -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Historia
                        </h3>
                        <p class="text-gray-700 leading-relaxed">{{ $mascota->historia }}</p>
                    </div>

                    <!-- Postulaciones recibidas -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Estadísticas de Postulaciones
                        </h3>
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-2xl font-bold text-blue-600">{{ $mascota->postulaciones->count() }}</p>
                                <p class="text-sm text-gray-600">Total postulaciones</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600">{{ $mascota->postulaciones->where('estado', 'aprobado')->count() }}</p>
                                <p class="text-sm text-gray-600">Aprobadas</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-yellow-600">{{ $mascota->postulaciones->where('estado', 'pendiente')->count() }}</p>
                                <p class="text-sm text-gray-600">Pendientes</p>
                            </div>
                        </div>
                        @if($mascota->postulaciones->where('estado', 'pendiente')->count() > 0)
                        <div class="mt-3 text-center">
                            <a href="{{ route('refugio.postulaciones.index') }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver postulaciones pendientes →
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3 pt-4 border-t">
                    <a href="{{ route('refugio.mascotas.edit', $mascota) }}" 
                       class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 rounded-lg transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar Mascota
                    </a>
                    
                    <form action="{{ route('refugio.mascotas.destroy', $mascota) }}" 
                          method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar a {{ $mascota->nombre }}?')"
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar Mascota
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($mascota->fotos->count() > 1)
<script>
    const fotos = @json($mascota->fotos->pluck('url'));
    let currentIndex = 0;
    
    function setMainImage(url, index) {
        document.getElementById('mainImage').src = url;
        currentIndex = index;
        
        // Actualizar borde de miniaturas
        const thumbnails = document.querySelectorAll('#thumbnail-container > div');
        thumbnails.forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.add('border-blue-500');
                thumb.classList.remove('border-transparent');
            } else {
                thumb.classList.remove('border-blue-500');
                thumb.classList.add('border-transparent');
            }
        });
    }
    
    function previousImage() {
        currentIndex = (currentIndex - 1 + fotos.length) % fotos.length;
        setMainImage(fotos[currentIndex], currentIndex);
    }
    
    function nextImage() {
        currentIndex = (currentIndex + 1) % fotos.length;
        setMainImage(fotos[currentIndex], currentIndex);
    }
</script>
@endif
@endsection