@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">🐾 Encuentra tu Mejor Amigo</h1>
        <p class="text-xl text-gray-600">Adopta, no compres. Dale una segunda oportunidad a estos peluditos</p>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Filtrar mascotas</h3>
        <form method="GET" action="{{ route('galeria.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 mb-2">Tipo de mascota</label>
                <select name="tipo" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="Perro" {{ request('tipo') == 'Perro' ? 'selected' : '' }}>🐕 Perros</option>
                    <option value="Gato" {{ request('tipo') == 'Gato' ? 'selected' : '' }}>🐱 Gatos</option>
                    <option value="Conejo" {{ request('tipo') == 'Conejo' ? 'selected' : '' }}>🐰 Conejos</option>
                    <option value="Ave" {{ request('tipo') == 'Ave' ? 'selected' : '' }}>🦜 Aves</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-2">Tamaño</label>
                <select name="tamaño" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="Pequeño" {{ request('tamaño') == 'Pequeño' ? 'selected' : '' }}>Pequeño</option>
                    <option value="Mediano" {{ request('tamaño') == 'Mediano' ? 'selected' : '' }}>Mediano</option>
                    <option value="Grande" {{ request('tamaño') == 'Grande' ? 'selected' : '' }}>Grande</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    🔍 Aplicar Filtros
                </button>
            </div>
        </form>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Grid de Mascotas -->
    @if($mascotas->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($mascotas as $mascota)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
            <!-- Carrusel de fotos simplificado onclick="window.location='{{ route('galeria.show', $mascota) }}'" -->
            <div class="relative h-64 bg-gray-200" cursor-pointer onclick="openModernModal({{ $mascota->id }})">
                @if($mascota->fotos->isNotEmpty())
                <img src="{{ $mascota->fotos->first()->url }}"
                    alt="{{ $mascota->nombre }}"
                    class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <span class="text-gray-400">📸 Sin foto</span>
                </div>
                @endif

                <!-- Badge de estado -->
                <div class="absolute top-2 right-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                            {{ $mascota->estado == 'disponible' ? 'bg-green-500 text-white' :
                               ($mascota->estado == 'en_proceso' ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white') }}">
                        {{ $mascota->estado == 'disponible' ? 'Disponible' :
                               ($mascota->estado == 'en_proceso' ? 'En proceso' : 'Adoptado') }}
                    </span>
                </div>
            </div>

            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-xl text-gray-800">{{ $mascota->nombre }}</h3>
                    <span class="text-sm text-gray-500">{{ $mascota->tipo }}</span>
                </div>

                <div class="space-y-2 mb-4">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">📏 Tamaño:</span> {{ $mascota->tamaño }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">🎂 Edad:</span> {{ $mascota->edad }}
                    </p>
                    <div class="flex gap-2 mt-2">
                        @if($mascota->esterilizado)
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">✅ Esterilizado</span>
                        @endif
                        @if($mascota->vacunado)
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">💉 Vacunado</span>
                        @endif
                    </div>
                </div>

                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {{ Str::limit($mascota->historia, 100) }}
                </p>

                @auth
                @if(auth()->user()->role === 'usuario' && $mascota->estado === 'disponible')
                <a href="{{ route('usuario.postular.create', $mascota) }}"
                    class="block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                    ❤️ ¡Quiero Adoptar!
                </a>
                @elseif(auth()->user()->role === 'usuario' && $mascota->estado !== 'disponible')
                <button disabled class="block text-center bg-gray-300 text-gray-500 py-2 rounded-lg cursor-not-allowed">
                    ⏳ No disponible
                </button>
                @elseif(auth()->user()->role !== 'usuario')
                <a href="{{ route('galeria.show', $mascota) }}"
                    class="block text-center bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition">
                    👁️ Ver Detalles
                </a>
                @endif
                @else
                <a href="{{ route('login') }}"
                    class="block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                    🔑 Inicia sesión para adoptar
                </a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $mascotas->links() }}
    </div>
    @else
    <div class="text-center py-12 bg-gray-50 rounded-lg">
        <p class="text-gray-500 text-lg">No hay mascotas disponibles en este momento.</p>
        <p class="text-gray-400 mt-2">¡Vuelve a visitarnos pronto!</p>
    </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
