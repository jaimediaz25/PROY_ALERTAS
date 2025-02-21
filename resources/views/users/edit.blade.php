<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        form {
            background: white;
            width: 50%;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <h2>Editar Usuario</h2>
    <form action="{{ route('users.update', $user['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="nombre" value="{{ $user['nombre'] }}" required>
        <input type="text" name="apellidos" value="{{ $user['apellidos'] }}" required>
        <input type="number" name="edad" value="{{ $user['edad'] }}" required>
        <input type="email" name="email" value="{{ $user['email'] }}" required>
        <select name="rol" required>
            <option value="usuario" {{ $user['rol'] == 'usuario' ? 'selected' : '' }}>Usuario</option>
            <option value="admin" {{ $user['rol'] == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="bombero" {{ $user['rol'] == 'bombero' ? 'selected' : '' }}>Bombero</option>
        </select>
        <button type="submit" class="btn">Actualizar</button>
    </form>
</body>
</html>
