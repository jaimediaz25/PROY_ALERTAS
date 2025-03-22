<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Lecturas</title>
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
            text-shadow: none;
        }

        .container {
            margin-top: 40px;
        }

        h3 {
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
            padding: 8px 16px;
            margin: 5px;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
            color: white;
        }

        .btn-primary {
            background: #c40000;
            border: none;
            
        }

        .btn-primary:hover {
            background: #9e0000;
            box-shadow: 0px 0px 20px rgba(255, 0, 0, 0.8);
            transform: scale(1.05);
            color: black;
        }

        .btn-info {
            background: black;
            border: none;
           
        }

        .btn-info:hover {
            background: black;
            box-shadow: 0px 0px 20px black;
            transform: scale(1.05);
            color: white;
        }

        .btn-warning {
            background: #f39c12;
            border: none;
           
        }

        .btn-warning:hover {
            background: #e67e22;
            box-shadow: 0px 0px 20px rgba(243, 156, 18, 0.8);
            transform: scale(1.05);
            color: black;
        }

        .btn-danger {
            background: #c40000;
            border: none;
           
        }

        .btn-danger:hover {
            background: #9e0000;
            box-shadow: 0px 0px 20px rgba(192, 57, 43, 0.8);
            transform: scale(1.05);
            color: black;
        }

        .btn-success {
            background: #28a745;
            border: none;
           
        }

        .btn-success:hover {
            background: #218838;
            box-shadow: 0px 0px 20px rgba(40, 167, 69, 0.8);
            transform: scale(1.05);
            color: black;
        }

        table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        table thead {
            background: linear-gradient(135deg, #c40000, #9e0000);
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
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('readings.index') }}">Lecturas</a>
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

        <h3>Lista de Lecturas</h3>

        <div class="d-flex justify-content-between">
            <form method="GET" action="{{ route('readings.index') }}" class="d-flex align-items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar lectura..." class="form-control mb-3" style="width: 250px;">
                <button type="submit" class="btn btn-primary btn-sm mb-3">Buscar</button>
            </form>

            <div>
                <a href="{{ route('readings.create') }}" class="btn btn-primary btn-sm mb-3">Nuevo Lectura</a>
                <a href="{{ route('readings.grafica') }}" class="btn btn-success btn-sm mb-3">Gráfica</a>
                <a href="{{ route('readings.exportPdf', request()->query()) }}" target="_blank" class="btn btn-info btn-sm mb-3">Descargar PDF</a> 
                <a href="{{ route('readings.exportExcel', request()->query()) }}" class="btn btn-info btn-sm mb-3">Descargar Excel</a>
                <form action="{{ route('readings.importExcel') }}" method="POST" enctype="multipart/form-data" class="import-form">
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
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sensor ID</th>
                    <th>Valor</th>
                    <th>Registrado En</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($readings as $reading)
                    <tr>
                        <td>{{ $reading['_id'] }}</td>
                        <td>{{ $reading['sensor_id'] }}</td>
                        <td>{{ $reading['valor'] }}</td>
                        <td>{{ $reading['registrado_en'] }}</td>
                        <td>
                            <a href="{{ route('readings.edit', $reading['_id']) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('readings.destroy', $reading['_id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-3">
            {{ $readings->links('pagination::bootstrap-4') }}
        </div>
    </div>
</body>
</html>
