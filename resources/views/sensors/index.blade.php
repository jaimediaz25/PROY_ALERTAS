<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Sensores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Arial', sans-serif;
            padding-top: 70px;
        }

        .navbar {
            background: linear-gradient(135deg, #c40000, #9e0000); /* Rojo más intenso */
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
            text-shadow: none; /* Sin neón en el texto */
        }

        .container {
            margin-top: 40px; /* Ajustado para que el título no esté tan abajo */
        }

        h2 {
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid #ccc;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        .btn {
            border-radius: 25px;
            padding: 8px 16px; /* Botones más pequeños */
            margin: 5px;
            font-size: 1rem; /* Texto más pequeño */
            transition: all 0.3s ease-in-out;
            color: white; /* Texto blanco */
        }

        .btn-primary {
            background: #c40000; /* Rojo más intenso */
            border: none;
           
        }

        .btn-primary:hover {
            background: #9e0000;
            box-shadow: 0px 0px 20px rgba(255, 0, 0, 0.8); /* Neón más notorio */
            transform: scale(1.05);
            color: black; /* Texto en negro al pasar el cursor */
        }

        .btn-info {
            background: black;
            border: none;
            
        }

        .btn-info:hover {
            background: black;
            box-shadow: 0px 0px 20px black; /* Neón más notorio */
            transform: scale(1.05);
            color: white; /* Texto en negro al pasar el cursor */
        }

        .btn-warning {
            background: #f39c12;
            border: none;
            
        }

        .btn-warning:hover {
            background: #e67e22;
            box-shadow: 0px 0px 20px rgba(243, 156, 18, 0.8); /* Neón más notorio */
            transform: scale(1.05);
            color: black; /* Texto en negro al pasar el cursor */
        }

        .btn-danger {
            background: #c40000; /* Rojo más intenso */
            border: none;
           
        }

        .btn-danger:hover {
            background: #9e0000;
            box-shadow: 0px 0px 20px rgba(192, 57, 43, 0.8); /* Neón más notorio */
            transform: scale(1.05);
            color: black; /* Texto en negro al pasar el cursor */
        }

        .btn-success {
            background: #28a745; /* Botón verde */
            border: none;
            
        }

        .btn-success:hover {
            background: #218838;
            box-shadow: 0px 0px 20px rgba(40, 167, 69, 0.8); /* Neón más notorio */
            transform: scale(1.05);
            color: black; /* Texto en negro al pasar el cursor */
        }

        table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        table thead {
            background: linear-gradient(135deg, #c40000, #9e0000); /* Rojo más intenso */
            color: white;
            font-weight: bold;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination .page-item .page-link {
            color: #d63031;
            border-radius: 30px;
            margin: 0 5px;
            transition: all 0.3s ease-in-out;
            padding: 10px 20px;
        }

        .pagination .page-item.active .page-link {
            background-color: #c40000;
            color: white;
            border: none;
        }

        .pagination .page-item .page-link:hover {
            background-color: #9e0000;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #e9ecef;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
        .import-form {
            display: flex;
            align-items: center;
            justify-content: center; /* Centrar el contenido */
            gap: 10px; /* Espacio entre los elementos */
            width: 100%;
            max-width: 400px; /* Ajustar el tamaño */
            margin: 0 auto; /* Centrar en la pantalla */
        }

        .import-form .input-container,
        .import-form .button-container {
            flex: 1; /* Mitad del espacio */
        }

        .import-form .input-container input {
            width: 100%; 
            margin-bottom: 2px; 
        }

        .import-form .button-container button {
            width: 100%;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <a href="{{ route('home')}}" class="btn btn-info btn-sm mb-3">INICIO</a> 
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('sensors.index') }}">Sensores</a>
            </div>
        </nav>

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

        @if(session('import_result'))
        <div class="alert alert-info">
            {{ session('import_result') }}
            @if(session('import_errors'))
                <ul class="mt-2">
                    @foreach(session('import_errors') as $error)
                        <li class="small text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        @endif

        <h2>Lista de Sensores</h2>

        <div class="d-flex justify-content-between">
            <form method="GET" action="{{ route('sensors.index') }}" class="d-flex align-items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar sensor..." class="form-control mb-3" style="width: 250px;">
                <button type="submit" class="btn btn-primary btn-sm mb-3">Buscar</button>
            </form>

            <div>
                <a href="{{ route('sensors.create') }}" class="btn btn-primary btn-sm mb-3">Nuevo Sensor</a>
                <a href="{{ route('sensors.grafica') }}" class="btn btn-success btn-sm mb-3">Gráfica</a>
                <a href="{{ route('sensors.exportPdf', request()->query()) }}" target="_blank" class="btn btn-info btn-sm mb-3">Descargar PDF</a> 
                <a href="{{ route('sensors.exportExcel', request()->query()) }}" class="btn btn-info btn-sm mb-3">Descargar Excel</a>
                <form action="{{ route('sensors.importExcel') }}" method="POST" enctype="multipart/form-data" class="import-form">
                    @csrf
                    <div class="input-container">
                        <input type="file" name="file" required class="form-control form-control-sm">
                    </div>
                    <div class="button-container">
                        <button type="submit" class="btn btn-secondary btn-sm">Importar</button>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Usuario</th>
                    <th>Ubicación</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sensors as $sensor)
                    <tr>
                        <td>{{ $sensor['_id'] }}</td>
                        <td>{{ $sensor['user_id'] }}</td>
                        <td>{{ $sensor['ubicacion'] }}</td>
                        <td>{{ $sensor['tipo'] }}</td>
                        <td>{{ $sensor['activo'] }}</td>
                        <td>
                            <a href="{{ route('sensors.edit', $sensor['_id']) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('sensors.destroy', $sensor['_id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        
        <div class="d-flex justify-content-center mt-3">
            {{ $sensors->links('pagination::bootstrap-4') }}
        </div>
    </div>
</body>
</html>
