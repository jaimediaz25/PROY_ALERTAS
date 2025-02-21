<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-2xl mb-4">Restablecer Contraseña</h2>

        @if(session('error'))
            <div class="bg-red-500 text-white p-2 mb-4 rounded">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('reset-password.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Correo electrónico</label>
                <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="newPassword" class="block text-sm font-medium text-gray-600">Nueva Contraseña</label>
                <input type="password" name="newPassword" id="newPassword" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Restablecer Contraseña</button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-blue-500">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>
