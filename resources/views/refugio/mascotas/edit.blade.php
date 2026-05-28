@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">✏️ Editar Mascota</h1>
            <p class="text-gray-600 mt-1">Actualiza la información de {{ $mascota->nombre }}</p>
        </div>
        <a href="{{ route('refugio.mascotas.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al listado
        </a>
    </div>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
            <div class="font-medium mb-2">Por favor corrige los siguientes errores:</div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulario Principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Información de la Mascota
                    </h2>
                </div>

                <form action="{{ route('refugio.mascotas.update', $mascota) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Nombre * <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre', $mascota->nombre) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nombre') border-red-500 @enderror"
                                   required>
                            @error('nombre')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Tipo * <span class="text-red-500">*</span>
                            </label>
                            <select name="tipo" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo') border-red-500 @enderror"
                                    required>
                                <option value="">Seleccionar...</option>
                                <option value="Perro" {{ old('tipo', $mascota->tipo) == 'Perro' ? 'selected' : '' }}>🐕 Perro</option>
                                <option value="Gato" {{ old('tipo', $mascota->tipo) == 'Gato' ? 'selected' : '' }}>🐱 Gato</option>
                                <option value="Conejo" {{ old('tipo', $mascota->tipo) == 'Conejo' ? 'selected' : '' }}>🐰 Conejo</option>
                                <option value="Ave" {{ old('tipo', $mascota->tipo) == 'Ave' ? 'selected' : '' }}>🦜 Ave</option>
                                <option value="Otro" {{ old('tipo', $mascota->tipo) == 'Otro' ? 'selected' : '' }}>🐾 Otro</option>
                            </select>
                            @error('tipo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Raza -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Raza</label>
                            <input type="text" 
                                   name="raza" 
                                   value="{{ old('raza', $mascota->raza) }}"
                                   placeholder="Ej: Labrador, Siames, etc."
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('raza')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Edad -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Edad * <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="edad" 
                                   value="{{ old('edad', $mascota->edad) }}"
                                   placeholder="Ej: 3 meses, 2 años"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('edad') border-red-500 @enderror"
                                   required>
                            @error('edad')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tamaño -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Tamaño * <span class="text-red-500">*</span>
                            </label>
                            <select name="tamaño" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tamaño') border-red-500 @enderror"
                                    required>
                                <option value="">Seleccionar...</option>
                                <option value="Pequeño" {{ old('tamaño', $mascota->tamaño) == 'Pequeño' ? 'selected' : '' }}>📏 Pequeño (hasta 5 kg)</option>
                                <option value="Mediano" {{ old('tamaño', $mascota->tamaño) == 'Mediano' ? 'selected' : '' }}>📏 Mediano (5-15 kg)</option>
                                <option value="Grande" {{ old('tamaño', $mascota->tamaño) == 'Grande' ? 'selected' : '' }}>📏 Grande (15+ kg)</option>
                            </select>
                            @error('tamaño')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Estado * <span class="text-red-500">*</span>
                            </label>
                            <select name="estado" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="disponible" {{ old('estado', $mascota->estado) == 'disponible' ? 'selected' : '' }}>✓ Disponible</option>
                                <option value="en_proceso" {{ old('estado', $mascota->estado) == 'en_proceso' ? 'selected' : '' }}>⏳ En proceso</option>
                                <option value="adoptado" {{ old('estado', $mascota->estado) == 'adoptado' ? 'selected' : '' }}>❤️ Adoptado</option>
                            </select>
                            @error('estado')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Historia -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Historia * <span class="text-red-500">*</span>
                            </label>
                            <textarea name="historia" 
                                      rows="6"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('historia') border-red-500 @enderror"
                                      required>{{ old('historia', $mascota->historia) }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Cuéntanos la historia de esta mascota, su personalidad, comportamiento, etc.</p>
                            @error('historia')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Características -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-3">Características de salud</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                           name="esterilizado" 
                                           value="1"
                                           {{ old('esterilizado', $mascota->esterilizado) ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-500">
                                    <span>✅ Está esterilizado/a</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                           name="vacunado" 
                                           value="1"
                                           {{ old('vacunado', $mascota->vacunado) ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-500">
                                    <span>💉 Está vacunado/a</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                        <a href="{{ route('refugio.mascotas.index') }}" 
                           class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Actualizar Mascota
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panel Lateral - Galería de Fotos -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-4">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Galería de Fotos
                    </h2>
                </div>

                <div class="p-6">
                    <!-- Fotos actuales -->
                    @if($mascota->fotos->count() > 0)
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Fotos actuales ({{ $mascota->fotos->count() }})</label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($mascota->fotos as $foto)
                                <div class="relative group">
                                    <img src="{{ $foto->url }}" 
                                         alt="Foto {{ $loop->index + 1 }}"
                                         class="w-full h-24 object-cover rounded-lg border-2 {{ $foto->es_principal ? 'border-blue-500' : 'border-gray-200' }}">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <form action="{{ route('refugio.foto.eliminar', $foto) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('¿Eliminar esta foto?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    @if($foto->es_principal)
                                        <span class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-1 rounded">Principal</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Las fotos con borde azul son la principal</p>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6 text-center mb-6">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-500">No hay fotos</p>
                        </div>
                    @endif

                    <!-- Agregar nuevas fotos -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3">Agregar nuevas fotos</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer"
                             onclick="document.getElementById('nuevas_fotos').click()">
                            <input type="file" 
                                   name="nuevas_fotos[]" 
                                   id="nuevas_fotos"
                                   multiple
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewNewImages(this)">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p class="text-gray-600">Haz clic para seleccionar imágenes</p>
                            <p class="text-sm text-gray-400 mt-1">Puedes seleccionar múltiples (Max 10, 2MB cada una)</p>
                        </div>
                        <div id="newImagesPreview" class="grid grid-cols-3 gap-3 mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewNewImages(input) {
    const preview = document.getElementById('newImagesPreview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-green-500">
                    <span class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">Nueva</span>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection