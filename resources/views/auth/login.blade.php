<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-2xl mb-4">Login</h2>

        @if(session('error'))
            <div class="bg-red-500 text-white p-2 mb-4 rounded">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Correo electrónico</label>
                <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Iniciar sesión</button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-blue-500">¿No tienes cuenta? Regístrate</a>
            <br>
            <a href="{{ route('reset-password') }}" class="text-blue-500">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</body>
</html>
