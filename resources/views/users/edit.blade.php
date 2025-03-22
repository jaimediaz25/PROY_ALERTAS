<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-container .image {
            width: 50%;
            background-image: url('https://cdn-icons-png.flaticon.com/512/1/1663.png'); /* Imagen opcional */
            background-size: cover;
            background-position: center;
        }

        .form-container .form-content {
            width: 50%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input, select, button {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 2px solid #ccc;
            font-size: 1rem;
            font-weight: 500;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #c40000; /* Rojo intenso */
            outline: none;
            box-shadow: 0 0 5px rgba(196, 0, 0, 0.5); /* Rojo intenso en el enfoque */
        }

        .btn {
            background-color: #c40000; /* Rojo intenso */
            color: black;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(196, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #9b0000; /* Rojo más oscuro al pasar el cursor */
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(196, 0, 0, 0.5);
            color: white;
        }

        .back-btn {
            background-color: #f39c12;
            color: black;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            padding: 12px 25px;
            border-radius: 7px;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 15px rgba(243, 156, 18, 0.3);
        }

        .back-btn:hover {
            background-color: #e67e22;
            box-shadow: 0px 6px 25px rgba(243, 156, 18, 0.5);
            transform: scale(1.05);
            color: white;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <div class="image"></div>
        <div class="form-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <h2>Editar Usuario</h2>

            <form action="{{ route('users.update', $user['_id']) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="nombre" value="{{ $user['nombre'] }}" placeholder="Nombre" required>
                <input type="text" name="apellidos" value="{{ $user['apellidos'] }}" placeholder="Apellidos" required>
                <input type="number" name="edad" value="{{ $user['edad'] }}" placeholder="Edad" required>
                <input type="email" name="email" value="{{ $user['email'] }}" placeholder="E-mail" required>
                <select name="rol" required>
                    <option value="usuario" {{ $user['rol'] == 'usuario' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ $user['rol'] == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="bombero" {{ $user['rol'] == 'bombero' ? 'selected' : '' }}>Bombero</option>
                </select>
                <button type="submit" class="btn">Actualizar</button>
            </form>

            <a href="{{ url()->previous() }}" class="back-btn">Volver</a>
        </div>
    </div>
</div>

</body>
</html>