@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Mi Perfil</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nombre</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                        Actualizar Perfil
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4 text-red-600">Eliminar Cuenta</h2>
            <p class="text-gray-600 mb-4">Una vez eliminada tu cuenta, todos tus datos serán eliminados permanentemente.</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Contraseña</label>
                    <input type="password" 
                           name="password" 
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-red-500">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" 
                        class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600"
                        onclick="return confirm('¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.')">
                    Eliminar Cuenta
                </button>
            </form>
        </div>
    </div>
</div>
@endsection