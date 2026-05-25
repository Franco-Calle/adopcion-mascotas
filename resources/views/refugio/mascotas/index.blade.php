@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Mis Mascotas</h1>
        <a href="{{ route('refugio.mascotas.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Registrar Nueva Mascota
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($mascotas as $mascota)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($mascota->fotos->isNotEmpty())
                <img src="{{ $mascota->fotos->first()->url }}" 
                     alt="{{ $mascota->nombre }}"
                     class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">Sin foto</span>
                </div>
            @endif
            
            <div class="p-4">
                <h3 class="font-bold text-xl">{{ $mascota->nombre }}</h3>
                <p class="text-gray-600">{{ $mascota->tipo }} • {{ $mascota->edad }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ Str::limit($mascota->historia, 100) }}</p>
                
                <div class="mt-4 flex justify-between items-center">
                    <span class="px-2 py-1 text-xs rounded 
                        {{ $mascota->estado == 'disponible' ? 'bg-green-100 text-green-800' : 
                           ($mascota->estado == 'en_proceso' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($mascota->estado) }}
                    </span>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('refugio.mascotas.edit', $mascota) }}" 
                           class="text-blue-500 hover:text-blue-700">Editar</a>
                        
                        <form action="{{ route('refugio.mascotas.destroy', $mascota) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Eliminar esta mascota?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">No tienes mascotas registradas aún.</p>
            <a href="{{ route('refugio.mascotas.create') }}" class="text-blue-500 hover:underline">
                Registrar tu primera mascota
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $mascotas->links() }}
    </div>
</div>
@endsection