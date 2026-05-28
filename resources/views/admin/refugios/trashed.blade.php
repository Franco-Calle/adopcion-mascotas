@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🗑️ Refugios Eliminados</h1>
            <p class="text-gray-600 mt-1">Refugios que han sido eliminados del sistema</p>
        </div>
        <a href="{{ route('admin.refugios.index') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
            ← Volver a refugios activos
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Refugio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Eliminado el</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($refugios as $refugio)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-400 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($refugio->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $refugio->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $refugio->email }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $refugio->deleted_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.refugios.restore', $refugio->id) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                <button type="submit" 
                                        class="text-green-600 hover:text-green-900 text-sm font-medium"
                                        onclick="return confirm('¿Restaurar este refugio?')">
                                    Restaurar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            No hay refugios eliminados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $refugios->links() }}
        </div>
    </div>
</div>
@endsection