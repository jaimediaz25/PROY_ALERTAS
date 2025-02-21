<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
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
            background: #28a745;
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
    <h2>Crear Nuevo Usuario</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="number" name="edad" placeholder="Edad" required>
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="rol" required>
            <option value="usuario">Usuario</option>
            <option value="admin">Administrador</option>
            <option value="bombero">Bombero</option>
        </select>
        <button type="submit" class="btn">Guardar</button>
    </form>
</body>
</html>
