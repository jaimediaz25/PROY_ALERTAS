<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background: #333;
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            background: #28a745;
            margin: 5px;
            border-radius: 5px;
        }
        .btn-danger {
            background: #dc3545;
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
    <h2>Lista de Usuarios</h2>
    <a href="{{ route('users.create') }}" class="btn">Nuevo Usuario</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user['id'] }}</td>
            <td>{{ $user['nombre'] }} {{ $user['apellidos'] }}</td>
            <td>{{ $user['email'] }}</td>
            <td>{{ $user['rol'] }}</td>
            <td>
                <a href="{{ route('users.edit', $user['id']) }}" class="btn">Editar</a>
                <form action="{{ route('users.destroy', $user['id']) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
