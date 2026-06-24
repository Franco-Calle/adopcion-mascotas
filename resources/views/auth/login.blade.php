<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — {{ config('app.name', 'Adopción de Mascotas') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen flex flex-col items-center justify-center px-4">

    {{-- Encabezado --}}
    <div class="text-center mb-6">
        <span class="text-5xl">🐾</span>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Adopción de Mascotas</h1>
        <p class="text-gray-500 text-sm mt-1">Iniciá sesión para continuar</p>
    </div>

    {{-- Card --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- Header azul --}}
        <div class="bg-blue-500 px-8 py-5">
            <h2 class="text-xl font-bold text-white">Bienvenido de vuelta</h2>
            <p class="text-blue-100 text-sm mt-0.5">Ingresá tus datos para acceder</p>
        </div>

        {{-- Formulario --}}
        <div class="px-8 py-6">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Correo electrónico
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition {{ $errors->has('email') ? 'border-red-400' : '' }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Contraseña
                    </label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition {{ $errors->has('password') ? 'border-red-400' : '' }}">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Recordarme + ¿Olvidaste? --}}
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                        <input type="checkbox"
                               name="remember"
                               class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                        Recordarme
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-blue-500 hover:text-blue-700 transition">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                    Iniciar Sesión
                </button>
            </form>

            {{-- Link registro --}}
            <p class="text-center text-sm text-gray-600 mt-6">
                ¿No tenés cuenta?
                <a href="{{ route('register') }}"
                   class="text-blue-500 hover:text-blue-700 font-medium transition">
                    Registrate aquí
                </a>
            </p>

            {{-- Volver a galería --}}
            <p class="text-center mt-3">
                <a href="{{ route('galeria.index') }}"
                   class="text-sm text-gray-400 hover:text-gray-600 transition">
                    ← Volver a la galería
                </a>
            </p>

        </div>
    </div>

</div>

</body>
</html>
