@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">✏️ Editar Refugio</h1>
            <p class="text-gray-600 mt-1">Modifica la información de {{ $refugio->name }}</p>
        </div>
        <a href="{{ route('admin.refugios.show', $refugio) }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
            ← Volver al detalle
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <form action="{{ route('admin.refugios.update', $refugio) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre del Refugio -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Nombre del Refugio *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $refugio->name) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email *</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $refugio->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Teléfono</label>
                    <input type="text" 
                           name="telefono" 
                           value="{{ old('telefono', $refugio->telefono) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('telefono')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nueva Contraseña (opcional) -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nueva Contraseña (opcional)</label>
                    <input type="password" 
                           name="password" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Dejar en blanco para mantener actual">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Confirmar Nueva Contraseña</label>
                    <input type="password" 
                           name="password_confirmation" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Dirección</label>
                    <textarea name="direccion" 
                              rows="2"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('direccion', $refugio->direccion) }}</textarea>
                    @error('direccion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion" 
                              rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $refugio->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo URL -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">URL del Logo</label>
                    <input type="url" 
                           name="logo_url" 
                           value="{{ old('logo_url', $refugio->logo_url) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://ejemplo.com/logo.png">
                    <p class="text-sm text-gray-500 mt-1">Opcional - URL de la imagen del logo</p>
                    @error('logo_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                <a href="{{ route('admin.refugios.show', $refugio) }}" 
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Actualizar Refugio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection