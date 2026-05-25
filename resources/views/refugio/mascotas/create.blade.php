@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Registrar Nueva Mascota</h1>
        <a href="{{ route('refugio.mascotas.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Volver
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('refugio.mascotas.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nombre *</label>
                    <input type="text" 
                           name="nombre" 
                           value="{{ old('nombre') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                           required>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Tipo *</label>
                    <select name="tipo" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                            required>
                        <option value="">Seleccionar...</option>
                        <option value="Perro">Perro</option>
                        <option value="Gato">Gato</option>
                        <option value="Conejo">Conejo</option>
                        <option value="Ave">Ave</option>
                        <option value="Otro">Otro</option>
                    </select>
                    @error('tipo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Raza -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Raza</label>
                    <input type="text" 
                           name="raza" 
                           value="{{ old('raza') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Edad -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Edad *</label>
                    <input type="text" 
                           name="edad" 
                           value="{{ old('edad') }}"
                           placeholder="Ej: 3 meses, 2 años"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                           required>
                    @error('edad')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tamaño -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Tamaño *</label>
                    <select name="tamaño" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                            required>
                        <option value="">Seleccionar...</option>
                        <option value="Pequeño">Pequeño (hasta 5 kg)</option>
                        <option value="Mediano">Mediano (5-15 kg)</option>
                        <option value="Grande">Grande (15+ kg)</option>
                    </select>
                    @error('tamaño')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fotos -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Fotos * (Máximo 10)</label>
                    <input type="file" 
                           name="fotos[]" 
                           multiple
                           accept="image/*"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Puedes seleccionar múltiples fotos (Ctrl+clic)</p>
                    @error('fotos.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Historia -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Historia *</label>
                    <textarea name="historia" 
                              rows="5"
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                              required>{{ old('historia') }}</textarea>
                    <p class="text-sm text-gray-500">Cuéntanos la historia de esta mascota, su personalidad, etc.</p>
                    @error('historia')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Características -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="esterilizado" 
                               value="1"
                               class="mr-2">
                        <span class="text-gray-700">Está esterilizado/a</span>
                    </label>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="vacunado" 
                               value="1"
                               class="mr-2">
                        <span class="text-gray-700">Está vacunado/a</span>
                    </label>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" 
                        class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Publicar Mascota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection