@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-4">
        <a href="{{ route('galeria.index') }}" class="text-blue-500 hover:text-blue-700">
            ← Volver a la galería
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Galería de Fotos -->
            <div class="p-6">
                @if($mascota->fotos->isNotEmpty())
                    <!-- Foto Principal -->
                    <div class="mb-4">
                        <img src="{{ $mascota->fotos->first()->url }}" 
                             alt="{{ $mascota->nombre }}"
                             class="w-full h-96 object-cover rounded-lg shadow-md"
                             id="mainImage">
                    </div>
                    
                    <!-- Miniaturas -->
                    @if($mascota->fotos->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($mascota->fotos as $foto)
                        <div class="cursor-pointer">
                            <img src="{{ $foto->url }}" 
                                 alt="Foto {{ $loop->index + 1 }}"
                                 class="w-full h-24 object-cover rounded hover:opacity-75 transition"
                                 onclick="document.getElementById('mainImage').src = '{{ $foto->url }}'">
                        </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        <span class="text-gray-400 text-lg">📸 No hay fotos disponibles</span>
                    </div>
                @endif
            </div>

            <!-- Información de la Mascota -->
            <div class="p-6">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $mascota->nombre }}</h1>
                    <div class="flex gap-2 mb-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                            {{ $mascota->tipo }}
                        </span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                            {{ $mascota->tamaño }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm 
                            {{ $mascota->estado == 'disponible' ? 'bg-green-100 text-green-700' : 
                               ($mascota->estado == 'en_proceso' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                            {{ $mascota->estado == 'disponible' ? '✓ Disponible' : 
                               ($mascota->estado == 'en_proceso' ? '⏳ En proceso' : '❌ Adoptado') }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="border-b pb-3">
                        <h3 class="font-semibold text-gray-700 mb-2">📋 Información básica</h3>
                        <p><span class="font-medium">Raza:</span> {{ $mascota->raza ?: 'No especificada' }}</p>
                        <p><span class="font-medium">Edad:</span> {{ $mascota->edad }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <h3 class="font-semibold text-gray-700 mb-2">💉 Estado de salud</h3>
                        <p>✅ {{ $mascota->esterilizado ? 'Esterilizado/a' : 'No esterilizado/a' }}</p>
                        <p>✅ {{ $mascota->vacunado ? 'Vacunado/a' : 'Vacunación pendiente' }}</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">📖 Historia</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $mascota->historia }}</p>
                    </div>
                </div>

                <!-- Información del Refugio -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">🏠 Información del Refugio</h3>
                    <p class="font-medium">{{ $mascota->refugio->name }}</p>
                    @if($mascota->refugio->descripcion)
                        <p class="text-sm text-gray-600 mt-1">{{ $mascota->refugio->descripcion }}</p>
                    @endif
                    @if($mascota->refugio->telefono)
                        <p class="text-sm text-gray-600 mt-1">📞 {{ $mascota->refugio->telefono }}</p>
                    @endif
                </div>

                <!-- Botón de Adopción -->
                @auth
                    @if(auth()->user()->role === 'usuario')
                        @php
                            $yaPostulo = $mascota->postulaciones->where('usuario_id', auth()->id())->first();
                        @endphp
                        
                        @if($mascota->estado === 'disponible')
                            @if(!$yaPostulo)
                                <a href="{{ route('usuario.postular.create', $mascota) }}" 
                                   class="block text-center bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition text-lg font-semibold">
                                    🐾 Iniciar proceso de adopción
                                </a>
                            @else
                                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
                                    <p class="font-semibold">✅ Ya has postulado a esta mascota</p>
                                    <p class="text-sm mt-1">Estado de tu postulación: 
                                        <strong>{{ ucfirst($yaPostulo->estado) }}</strong>
                                    </p>
                                    <a href="{{ route('usuario.postulaciones.mis') }}" 
                                       class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                                        Ver mis postulaciones →
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-100 text-gray-600 text-center py-3 rounded-lg">
                                ⚠️ Esta mascota ya no está disponible para adopción
                            </div>
                        @endif
                    @elseif(auth()->user()->role === 'refugio')
                        <div class="bg-gray-100 text-gray-600 text-center py-3 rounded-lg">
                            👋 Eres un refugio. Puedes gestionar tus mascotas en tu panel.
                        </div>
                    @elseif(auth()->user()->role === 'admin')
                        <div class="bg-gray-100 text-gray-600 text-center py-3 rounded-lg">
                            👑 Bienvenido Administrador
                        </div>
                    @endif
                @else
                    <div class="bg-gray-100 rounded-lg p-4 text-center">
                        <p class="text-gray-600 mb-3">Para adoptar esta mascota, necesitas:</p>
                        <a href="{{ route('login') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                            Iniciar Sesión
                        </a>
                        <p class="text-sm text-gray-500 mt-2">¿No tienes cuenta? 
                            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Regístrate aquí</a>
                        </p>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection