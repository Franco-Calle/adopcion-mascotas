@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('galeria.show', $mascota) }}" class="text-blue-500 hover:text-blue-700">
                ← Volver a la mascota
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Cabecera con info de la mascota -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                <h1 class="text-2xl font-bold mb-2">Formulario de Adopción</h1>
                <p class="opacity-90">Estás postulando para adoptar a:</p>
                <div class="flex items-center gap-4 mt-2">
                    @if($mascota->fotos->isNotEmpty())
                        <img src="{{ $mascota->fotos->first()->url }}" 
                             alt="{{ $mascota->nombre }}"
                             class="w-16 h-16 rounded-full object-cover border-2 border-white">
                    @endif
                    <div>
                        <p class="font-bold text-xl">{{ $mascota->nombre }}</p>
                        <p>{{ $mascota->tipo }} • {{ $mascota->edad }} • {{ $mascota->tamaño }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('usuario.postular.store', $mascota) }}" method="POST" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Datos personales -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 Tus datos personales</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nombre completo *</label>
                                <input type="text" 
                                       name="nombre_completo" 
                                       value="{{ old('nombre_completo', auth()->user()->name) }}"
                                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                                       required>
                                @error('nombre_completo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Teléfono *</label>
                                <input type="tel" 
                                       name="telefono" 
                                       value="{{ old('telefono') }}"
                                       placeholder="Ej: 555-1234567"
                                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                                       required>
                                @error('telefono')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold mb-2">Dirección completa *</label>
                            <textarea name="direccion" 
                                      rows="3"
                                      class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                                      required>{{ old('direccion') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Incluye calle, número, colonia, ciudad, código postal</p>
                            @error('direccion')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preguntas sobre adopción -->
                    <div class="border-t pt-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">🏠 Sobre la adopción</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    ¿Por qué quieres adoptar esta mascota? *
                                </label>
                                <textarea name="razones" 
                                          rows="4"
                                          class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                                          required>{{ old('razones') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Cuéntanos qué te motivó a elegir a esta mascota</p>
                                @error('razones')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Experiencia previa con mascotas
                                </label>
                                <textarea name="experiencia_mascotas" 
                                          rows="3"
                                          class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                                          placeholder="¿Has tenido mascotas antes? ¿Cuál es tu experiencia cuidándolas?">{{ old('experiencia_mascotas') }}</textarea>
                                @error('experiencia_mascotas')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Compromiso -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">📋 Compromiso de adopción responsable</h3>
                        <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                            <li>Proveeré un hogar amoroso y seguro para la mascota</li>
                            <li>Cubriré todos los gastos de alimentación, veterinaria y cuidados</li>
                            <li>Me comprometo a mantenerla vacunada y desparasitada</li>
                            <li>Entiendo que la adopción es un compromiso de por vida</li>
                        </ul>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                            Enviar solicitud de adopción
                        </button>
                        <a href="{{ route('galeria.show', $mascota) }}" 
                           class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition text-center">
                            Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection