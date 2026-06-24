@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🏠 Registrar Nuevo Refugio</h1>
            <p class="text-gray-600 mt-1">Crea una cuenta para un nuevo refugio en la plataforma</p>
        </div>
        <a href="{{ route('admin.refugios.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
            ← Volver al listado
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <form action="{{ route('admin.refugios.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre del Refugio -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Nombre del Refugio *</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ej: Patitas Felices"
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
                           value="{{ old('email') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="contacto@refugio.com"
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
                           value="{{ old('telefono') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="555-1234567">
                    @error('telefono')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Contraseña *</label>
                    <input type="password"
                           name="password"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Mínimo 8 caracteres"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Confirmar Contraseña *</label>
                    <input type="password"
                           name="password_confirmation"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Dirección</label>
                    <textarea name="direccion"
                              rows="2"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Dirección completa del refugio">{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion"
                              rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Describe la misión y labor del refugio...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

           </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                <a href="{{ route('admin.refugios.index') }}"
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Registrar Refugio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
