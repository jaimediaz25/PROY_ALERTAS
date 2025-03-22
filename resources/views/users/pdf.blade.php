<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-top: 30px;
            padding: 10px;
            background-color: #c40000;
            color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para la tabla */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #c40000;
            color: white;
            font-size: 1.1rem;
        }

        td {
            background-color: #f9f9f9;
            color: #333;
            font-size: 1rem;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background-color: #f1c6c6; /* Color de hover */
            transition: background-color 0.3s ease;
        }

        /* Estilos de los bordes */
        th, td {
            border: 1px solid #ddd;
        }

        /* Estilos del pie de página */
        footer {
            text-align: center;
            margin-top: 30px;
            padding: 10px;
            background-color: #c40000;
            color: white;
            font-size: 1rem;
        }

        /* Ajustes de estilo para las celdas */
        td, th {
            border-radius: 4px;
        }
        @media print {
            body { font-size: 12pt; }
            table { width: 100%; page-break-inside: auto; }
            tr { page-break-inside: avoid; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="no-print">Imprimir/Guardar como PDF</button>
    <h2>Lista de Usuarios</h2>

    <table>
        <thead>
            <tr>
                
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Edad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    
                    <td>{{ $user['nombre'] }} {{ $user['apellidos'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['rol'] }}</td>
                    <td>{{ $user['edad'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No se encontraron registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <script>
        // Auto-imprimir al abrir el archivo
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>