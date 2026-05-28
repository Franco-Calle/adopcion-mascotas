@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📋 Postulaciones Recibidas</h1>
            <p class="text-gray-600 mt-1">Gestiona las solicitudes de adopción de tus mascotas</p>
        </div>
        <a href="{{ route('refugio.mascotas.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a mis mascotas
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

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar por mascota o postulante</label>
                <input type="text" id="searchInput" placeholder="Nombre de mascota o postulante..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filtrar por estado</label>
                <select id="statusFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="todos">Todos</option>
                    <option value="pendiente">⏳ Pendiente</option>
                    <option value="aprobado">✅ Aprobado</option>
                    <option value="rechazado">❌ Rechazado</option>
                </select>
            </div>
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                <select id="sortFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="recientes">Más recientes</option>
                    <option value="antiguos">Más antiguos</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Listado de Postulaciones -->
    @if($postulaciones->count() > 0)
        <div class="space-y-4" id="postulacionesList">
            @foreach($postulaciones as $postulacion)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition card-postulacion"
                 data-mascota="{{ strtolower($postulacion->mascota->nombre) }}"
                 data-postulante="{{ strtolower($postulacion->nombre_completo) }}"
                 data-estado="{{ $postulacion->estado }}"
                 data-fecha="{{ $postulacion->created_at->timestamp }}">
                
                <div class="flex flex-col md:flex-row">
                    <!-- Foto de la mascota -->
                    <div class="md:w-48 h-48 bg-gray-200">
                        @if($postulacion->mascota->fotos->isNotEmpty())
                            <img src="{{ $postulacion->mascota->fotos->first()->url }}" 
                                 alt="{{ $postulacion->mascota->nombre }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Información -->
                    <div class="flex-1 p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h2 class="text-xl font-bold text-gray-800">{{ $postulacion->mascota->nombre }}</h2>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                        {{ $postulacion->mascota->tipo }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-3">
                                    <span class="font-medium">Postulante:</span> {{ $postulacion->nombre_completo }}
                                </p>
                                
                                <div class="flex flex-wrap gap-3 text-sm text-gray-500 mb-3">
                                    <span>📞 {{ $postulacion->telefono }}</span>
                                    <span>📧 {{ $postulacion->email }}</span>
                                    <span>📅 {{ $postulacion->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    <span class="font-medium">Motivos:</span> {{ Str::limit($postulacion->razones, 100) }}
                                </p>
                            </div>

                            <div class="flex flex-col items-end gap-3">
                                <!-- Estado -->
                                <div>
                                    @switch($postulacion->estado)
                                        @case('pendiente')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Pendiente
                                            </span>
                                            @break
                                        @case('aprobado')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Aprobado
                                            </span>
                                            @break
                                        @case('rechazado')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Rechazado
                                            </span>
                                            @break
                                    @endswitch
                                </div>

                                <!-- Botón ver detalles -->
                                <a href="{{ route('refugio.postulaciones.show', $postulacion) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition text-sm font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver detalles
                                </a>
                            </div>
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
            <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay postulaciones</h3>
            <p class="text-gray-500">Aún no has recibido solicitudes de adopción para tus mascotas</p>
        </div>
    @endif
</div>

<script>
    // Filtros dinámicos
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const sortFilter = document.getElementById('sortFilter');
    const container = document.getElementById('postulacionesList');
    
    function filterAndSort() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const sortValue = sortFilter.value;
        
        let cards = Array.from(document.querySelectorAll('.card-postulacion'));
        
        // Filtrar
        cards = cards.filter(card => {
            const mascota = card.dataset.mascota;
            const postulante = card.dataset.postulante;
            const estado = card.dataset.estado;
            
            let show = true;
            if (searchTerm && !mascota.includes(searchTerm) && !postulante.includes(searchTerm)) show = false;
            if (statusValue !== 'todos' && estado !== statusValue) show = false;
            
            return show;
        });
        
        // Ordenar
        cards.sort((a, b) => {
            const fechaA = parseInt(a.dataset.fecha);
            const fechaB = parseInt(b.dataset.fecha);
            return sortValue === 'recientes' ? fechaB - fechaA : fechaA - fechaB;
        });
        
        // Reordenar DOM
        cards.forEach(card => container.appendChild(card));
        
        // Mostrar mensaje si no hay resultados
        if (cards.length === 0) {
            if (!document.getElementById('noResults')) {
                const noResults = document.createElement('div');
                noResults.id = 'noResults';
                noResults.className = 'text-center py-8 text-gray-500';
                noResults.innerHTML = 'No se encontraron postulaciones';
                container.appendChild(noResults);
            }
        } else {
            const noResults = document.getElementById('noResults');
            if (noResults) noResults.remove();
        }
    }
    
    searchInput.addEventListener('input', filterAndSort);
    statusFilter.addEventListener('change', filterAndSort);
    sortFilter.addEventListener('change', filterAndSort);
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection